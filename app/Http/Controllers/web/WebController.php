<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\otpVerifcation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;
use Deyjandi\VivaWallet\Enums\RequestLang;
use Deyjandi\VivaWallet\Enums\PaymentMethod;
use Deyjandi\VivaWallet\Facades\VivaWallet;
use Deyjandi\VivaWallet\Customer;
use Deyjandi\VivaWallet\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Client;
use Symfony\Component\CssSelector\Parser\Shortcut\ElementParser;
use SebastianBergmann\Type\NullType;

use App\Mail\OrderConfirmation;
use App\Notifications\UserOrderNotification;
use Illuminate\Support\Facades\Notification;

// models ...
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Question;
use App\Models\AssignQuestion;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Transaction;
use App\Models\UserBmi;
use App\Models\UserConsultation;
use App\Models\Cart;
use App\Models\Order;
use App\Models\QuestionMapping;
use App\Models\QuestionCategory;
use App\Models\PMedGeneralQuestion;
use App\Models\PrescriptionMedGeneralQuestion;
use App\Models\Pharmacy4uGpLocation;
use App\Models\ShipingDetail;
use App\Models\OrderDetail;
use App\Models\Alert;
use App\Models\FaqProduct;
use App\Models\ProductVariant;
use App\Models\PaymentDetail;
use App\Models\HumanRequestForm;

class WebController extends Controller
{
    private $menu_categories;
    protected $status;
    protected $ENV;
    public function __construct()
    {
        $this->status = config('constants.STATUS');

        $this->menu_categories = Category::where('status', 'Active')
            ->with(['subcategory' => function ($query) {
                $query->where('status', 'Active')
                    ->with(['childCategories' => function ($query) {
                        $query->where('status', 'Active');
                    }]);
            }])
            ->where('publish', 'Publish')
            ->latest('id')
            ->get()
            ->toArray();

        view()->share('menu_categories', $this->menu_categories);
        $this->ENV = env('PAYMENT_ENV', 'Live') ?? 'Live'; //1. Live, 2. Local.
    }

    public function shop(Request $request, $category = null, $sub_category = null, $child_category = null)
    {
        // use with route shop
        $slug = [
            "main_category" => $category,
            "sub_category" => $sub_category,
            "child_category" => $child_category
        ];

        $consultations = session('consultations') ?? [];
        $found = false;
        foreach ($consultations as $consultation) {
            if (isset($consultation['slug']) && $slug == $consultation['slug']) {
                if ($consultation['gen_quest_ans'] != '' && $consultation['pro_quest_ans'] != '') {
                    $found = true;
                    break;
                }
            }
        }

        if ($found) {
            $data['pre_add_to_cart'] = 'yes';
        } else {
            $data['pre_add_to_cart'] = 'no';
        }

        // product listing
        $level = '';
        if ($category && $sub_category && $child_category) {
            $level = 'child';
            $category_detail = ChildCategory::where('slug', $child_category)->first();
        } else if ($category && $sub_category && !$child_category) {
            $level = 'sub';
            $category_detail = SubCategory::where('slug', $sub_category)->first();
        } else if ($category && !$sub_category && !$child_category) {
            $level = 'main';
            $category_detail = Category::where('slug', $category)->first();
        }

        switch ($level) {
            case 'main':
                $products = Product::where(['status' => $this->status['Active'], 'category_id' => $category_detail->id])->paginate(20);
                break;
            case 'sub':
                $products = Product::where(['status' => $this->status['Active'], 'sub_category' => $category_detail->id])->paginate(20);
                break;
            case 'child':
                $products = Product::where(['status' => $this->status['Active'], 'child_category' => $category_detail->id])->paginate(20);
                break;
            default:
                $query = Product::query()->where('status', $this->status['Active']);
                if ($request->has('sort')) {
                    if ($request->sort === 'price_low_high') {
                        $query->orderBy('price');
                    } elseif ($request->sort === 'price_high_low') {
                        $query->orderByDesc('price');
                    } elseif ($request->sort === 'newest') {
                        $query->orderByDesc('created_at');
                    }
                }
                $products = $query->paginate(21);
        }

        $data['products'] = $products;
        $data['categories_list'] = Category::where('publish', 'Publish')
            ->latest('id')
            ->get();

        return view('web.pages.shop', $data);
    }

    public function show_products(Request $request, $category = null, $sub_category = null, $child_category = null)
    {
        // use with route category
        $slug = [
            "main_category" => $category,
            "sub_category" => $sub_category,
            "child_category" => $child_category
        ];

        $consultations = session('consultations') ?? [];
        $found = false;
        foreach ($consultations as $consultation) {
            if (isset($consultation['slug']) && $slug == $consultation['slug']) {
                if ($consultation['gen_quest_ans'] != '' && $consultation['pro_quest_ans'] != '') {
                    $found = true;
                    break;
                }
            }
        }

        if ($found) {
            $data['pre_add_to_cart'] = 'yes';
        } else {
            $data['pre_add_to_cart'] = 'no';
        }


        // product listing
        $level = '';
        if ($category && $sub_category && $child_category) {
            $level = 'child';
            $category_detail = ChildCategory::where('slug', $child_category)->where('status', 'Active')->first();
        } else if ($category && $sub_category && !$child_category) {
            $level = 'sub';
            $category_detail = SubCategory::where('slug', $sub_category)->where('status', 'Active')->first();
        } else if ($category && !$sub_category && !$child_category) {
            $level = 'main';
            $category_detail = Category::where('slug', $category)->where('status', 'Active')->first();
        }
        // return $level;
        if ($category_detail) {
            switch ($level) {
                case 'main':
                    $products = Product::where(['status' => $this->status['Active'], 'category_id' => $category_detail->id])->paginate(28);
                    break;
                case 'sub':
                    $products = Product::where(['status' => $this->status['Active'], 'sub_category' => $category_detail->id])->paginate(28);
                    break;
                case 'child':
                    $products = Product::where(['status' => $this->status['Active'], 'child_category' => $category_detail->id])->paginate(28);
                    break;
                default:
                    $products = Product::where('status', $this->status['Active'])->paginate(28);
            }

            $data['products'] = $products;
            $product_template_2_ids = [];
            foreach ($products as $item) {
                if ($item->product_template == config('constants.PRESCRIPTION_MEDICINE')) {
                    $product_template_2_ids[] = $item->id;
                }
            }
            $data['product_ids'] = implode(',', $product_template_2_ids);
            $data['categories_list'] = Category::where('publish', 'Publish')
                ->latest('id')
                ->get();
            $data['category_detail'] = $category_detail;

            return view('web.pages.products_list', $data);
        } else {
            return view('web.pages.404');
        }
    }

    public function products(Request $request)
    {
        session()->forget('pro_id');
        $cat_id = $request->input('cat_id') ?? NULL;
        $data['user'] = auth()->user() ?? [];
        $query = Product::with('category:id,name')->where('status', $this->status['Active'])->latest('id');
        if ($cat_id) {
            $query->where('category_id', $cat_id);
        }
        $data['products'] = $query->get()->toArray();

        $data['categories'] = Category::withCount('products')->latest('id')->get()->toArray();

        return view('web.pages.products', $data);
    }

    public function product_detail(Request $request, $slug)
    {

        $data['user'] = auth()->user() ?? [];
        // $data['product'] = Product::with('category:id,name,slug', 'sub_cat:id,name,slug', 'child_cat:id,name,slug', 'variants')->findOrFail($request->id);
        $data['product'] = Product::with('productAttributes:id,product_id,image', 'category:id,name,slug', 'sub_cat:id,name,slug', 'child_cat:id,name,slug', 'variants')->where('slug', $slug)->where('status', $this->status['Active'])->firstOrFail();
        $variants = $data['product']['variants']->toArray() ?? [];
        if ($variants) {
            $variants_tags = [];
            foreach ($variants as $variant) {
                $variant_selectors = explode(';', $variant['title']);
                $variant_values = explode(';', $variant['value']);
                foreach ($variant_selectors as $index => $selector) {
                    if (!in_array($variant_values[$index], $variants_tags[$selector] ?? [])) {
                        $variants_tags[$selector][] = $variant_values[$index];
                    }
                }
            }
            $modifyValue = function ($value) {
                return str_replace([';', ' '], ['', '_'], trim($value));
            };

            $data['varints_selectors'] = explode(';', $variants[0]['title'] ?? '');
            $data['variants_tags']  = $variants_tags;
            $data['variants'] = array_combine(array_map($modifyValue, array_column($variants, 'value')), $variants);
        }
        if ($data['product']) {
            $data['pre_add_to_cart']  = 'no';
            foreach (session('consultations') ?? [] as $key => $value) {
                if ($key == $data['product']->id || strpos($key, ',') !== false && in_array($data['product']->id, explode(',', $key))) {
                    if (isset(session('consultations')[$key]) && session('consultations')[$key]['gen_quest_ans'] != '' && session('consultations')[$key]['pro_quest_ans'] != '') {
                        $data['pre_add_to_cart']  = 'yes';
                        break;
                    }
                }
            }
            $data['related_products'] = $this->get_related_products($data['product']);
            $data['faqs'] = FaqProduct::where(['status' => 'Active', 'product_id' => $data['product']->id])
                ->orderByRaw('IF(`order` IS NULL, 1, 0), CAST(`order` AS UNSIGNED), `order`')
                ->orderBy('id')
                ->get()
                ->toArray();
            return view('web.pages.product', $data);
        } else {
            redirect()->back();
        }
    }



    public function consultation_form(Request $request)
    {
        $data['user'] = auth()->user() ?? [];
        $data['template'] = $request->template ?? session('template');
        $data['product_id'] = $request->product_id ?? session('product_id');
        if ($data['template'] == config('constants.PHARMACY_MEDECINE')) {
            $data['questions'] = PMedGeneralQuestion::where(['status' => 'Active'])->get()->toArray();
            return view('web.pages.pmd_genral_question', $data);
        } else if ($data['template'] == config('constants.PRESCRIPTION_MEDICINE')) {
            if (auth()->user()) {
                if ($data['user']->id_document ?? Null) {
                    foreach (session('consultations') ?? [] as $key => $value) {
                        if ($key == $data['product_id'] || strpos($key, ',') !== false && in_array($data['product_id'], explode(',', $key))) {
                            if (isset(session('consultations')[$key]) && session('consultations')[$key]['gen_quest_ans'] != '') {
                                return redirect()->route('web.productQuestion', ['id' => $key]);
                                break;
                            }
                        }
                    }

                    $data['questions'] = PrescriptionMedGeneralQuestion::where(['status' => 'Active'])->get()->toArray();
                    $data['gp_locations'] = Pharmacy4uGpLocation::where('status', 'Active')->latest('id')->get()->toArray();
                    return view('web.pages.premd_genral_question', $data);
                } else {
                    session()->put('intended_url', 'fromConsultation');
                    session()->put('template', $data['template']);
                    session()->put('product_id', $data['product_id']);
                    return redirect()->route('web.idDocumentForm');
                }
            } else {
                session()->put('intended_url', 'fromConsultation');
                session()->put('template', $data['template']);
                session()->put('product_id', $data['product_id']);
                return redirect()->route('login');
            }
        } else {
            return redirect()->back();
        }
    }

    public function id_document_form(Request $request)
    {
        $user = auth()->user();
        if ($user->id_document ?? Null) {
            return redirect()->back();
        } else {
            return view('web.pages.id_document_form', [$user]);
        }
    }

    public function id_document_store(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), ['id_document'   => 'required',]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->file('id_document')) {
            $doc = $request->file('id_document');
            $docName = uniqid() . time() . '_' . $doc->getClientOriginalName();
            $doc->storeAs('user_docs', $docName, 'public');
            $docPath = 'user_docs/' . $docName;
        }
        $user = User::findOrFail($user->id);
        $user->update([
            'id_document' => $docPath,
        ]);

        return redirect()->route('web.consultationForm');
    }

    public function consultation_store(Request $request)
    {
        $consultations = Session::get('consultations', []);
        $questionAnswers = [];
        foreach ($request->all() as $key => $value) {
            if ($key === '_token' || $key === 'template') {
                continue;
            }
            if (strpos($key, 'quest_') === 0) {
                $question_id = substr($key, 6);
                $questionAnswers[$question_id] = $value;
            }
        }

        $consultationData = [];
        if ($request->template == config('constants.PHARMACY_MEDECINE')) {
            $consultationData = ['type' => 'pmd', 'product_id' => $request->product_id, 'gen_quest_ans' => $questionAnswers, 'pro_quest_ans' => ''];
        } else {
            $product_ids = explode(',', $request->product_id);
            $category = Product::with('category', 'sub_cat', 'child_cat')->where('status', $this->status['Active'])->find($product_ids[0]);
            $slug = ['main_category' => $category->category->slug, 'sub_category' => $category->sub_cat->slug ?? null, 'child_category' => $category->child_cat->slug ?? null];
            $consultationData = ['type' => 'premd', 'product_id' => $request->product_id, 'slug' => $slug, 'gen_quest_ans' => $questionAnswers, 'pro_quest_ans' => ''];
        }

        if ($request->template == config('constants.PHARMACY_MEDECINE')) {
            $consultations[$request->product_id] = $consultationData;
            Session::put('consultations', $consultations);
            $prod = Product::findOrFail($request->product_id);
            return redirect()->route('web.product', ['id' => $prod->slug]);
        } else {
            $consultations[$request->product_id] = $consultationData;
            Session::put('consultations', $consultations);
            return redirect()->route('web.productQuestion', ['id' => $request->product_id]);
        }
    }

    public function product_question(Request $request)
    {
        $data['user'] = auth()->user() ?? [];
        if (auth()->user()) {
            if (isset(session('consultations')[$request->id])) {
                $generic_consultation = (isset(session('consultations')[$request->id]['gen_quest_ans'])) ? true : false;
                if (!$generic_consultation) {
                    return redirect()->back();
                }
            } else {
                return redirect()->back();
            }

            $data['template'] = config('constants.PRESCRIPTION_MEDICINE');
            $data['product_id'] = $request->id;
            $data['product_detail'] = Product::find($request->id);
            $quest_category_id = $data['product_detail']->question_category;
            $questions = Question::where(['category_id' => $quest_category_id, 'status' => 'Active'])
                ->orderByRaw('IF(`order` IS NULL, 1, 0), CAST(`order` AS UNSIGNED), `order`')
                ->orderBy('id')
                ->get()
                ->toArray();
            $question_map_cat  = QuestionMapping::where('category_id', $quest_category_id)->get()->toArray();
            $data['alerts']  =  Alert::where('q_category_id', $quest_category_id)->get()->keyBy('id')->toArray();
            $data['questions'] = [];
            $data['dependent_questions'] = [];
            foreach ($questions as $key => $quest) {
                $q_id = $quest['id'];
                $quest['selector'] = [];
                $quest['next_type'] = [];
                if ($quest['anwser_set'] == "mt_choice") {
                    foreach ($question_map_cat as $key => $val1) {
                        if ($val1['question_id'] == $q_id && $val1['answer'] == 'optA') {
                            $quest['selector']['optA'] = $val1['selector'];
                            $quest['next_type']['optA'] = $val1['next_type'];
                        } elseif ($val1['question_id'] == $q_id && $val1['answer'] == 'optB') {
                            $quest['selector']['optC'] = $val1['selector'];
                            $quest['next_type']['optB'] = $val1['next_type'];
                        } elseif ($val1['question_id'] == $q_id && $val1['answer'] == 'optC') {
                            $quest['selector']['optC'] = $val1['selector'];
                            $quest['next_type']['optC'] = $val1['next_type'];
                        } elseif ($val1['question_id'] == $q_id && $val1['answer'] == 'optD') {
                            $quest['selector']['optD'] = $val1['selector'];
                            $quest['next_type']['optD'] = $val1['next_type'];
                        }
                    }
                } else if ($quest['anwser_set'] == "yes_no") {
                    foreach ($question_map_cat as $key => $val2) {
                        if ($val2['question_id'] == $q_id && $val2['answer'] == 'optY') {
                            $quest['selector']['yes_lable'] = $val2['selector'];
                            $quest['next_type']['yes_lable'] = $val2['next_type'];
                        } elseif ($val2['question_id'] == $q_id && $val2['answer'] == 'optN') {
                            $quest['selector']['no_lable']  = $val2['selector'];
                            $quest['next_type']['no_lable'] = $val2['next_type'];
                        }
                    }
                } else if ($quest['anwser_set'] == "file") {
                    foreach ($question_map_cat as $key => $val3) {
                        if ($val3['question_id'] == $q_id && $val3['answer'] == 'file') {
                            $quest['selector']['file'] = $val3['selector'];
                            $quest['next_type']['file'] = $val3['next_type'];
                        }
                    }
                } else if ($quest['anwser_set'] == "openbox") {
                    foreach ($question_map_cat as $key => $val4) {
                        if ($val4['question_id'] == $q_id && $val4['answer'] == 'openBox') {
                            $quest['selector']['openbox'] = $val4['selector'];
                            $quest['next_type']['openbox'] = $val4['next_type'];
                        }
                    }
                }
                if ($quest['is_dependent'] == 'yes') {
                    $data['dependent_questions'][$q_id] = $quest;
                } else {
                    $data['questions'][] = $quest;
                }
            }

            // dd($data);
            return view('web.pages.product_question', $data);
        } else {
            session()->put('intended_url', 'fromConsultation');
            return redirect()->route('register');
        }
    }

    public function transaction_store(Request $request)
    {
        if (auth()->user()) {
            if (isset(session('consultations')[$request->product_id])) {
                $productSession = session('consultations')[$request->product_id];
                $generic_consultation = isset($productSession['gen_quest_ans']);

                if ($generic_consultation) {
                    $questionAnswers = [];
                    foreach ($request->all() as $key => $value) {
                        if ($key === '_token' || $key === 'template') {
                            continue;
                        }
                        if (strpos($key, 'quest_') === 0) {
                            $question_id = substr($key, 6);
                            $questionAnswers[$question_id] = $value;
                        } else if (strpos($key, 'qfid_') === 0) {
                            $question_id = substr($key, 5);
                            if ($request->hasFile($key)) {
                                $file = $request->file($key);
                                $fileName = time() . '_' . uniqid('', true) . '.' . $file->getClientOriginalExtension();
                                $file->storeAs('consultation/product', $fileName, 'public');
                                $filePath = 'consultation/product/' . $fileName;
                                $questionAnswers[$question_id] = $filePath;
                            }
                        }
                    }

                    $productSession['pro_quest_ans'] = $questionAnswers;
                    session(['consultations.' . $request->product_id => $productSession]);
                    $slug = session('consultations')[$request->product_id]['slug'];
                    return redirect()->route('category.products', $slug);
                } else {
                    return redirect()->route('shop');
                }
            } else {
                return redirect()->route('shop');
            }
        } else {
            session()->put('intended_url', 'fromConsultation');
            return redirect()->route('login');
        }
    }

    public function view_cart(Request $request)
    {
        $data['cart'] = session('cart');
        // return $data['cart']->product_data;
        return view('web.pages.cart', $data);
    }

    public function add_to_cart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $productData = json_decode($request->input('product_data'), true);

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity,
                'product_data' => $productData
            ];
        }

        Session::put('cart', $cart);

        return response()->json(['message' => 'Item added to cart']);
    }

    public function show_categories(Request $request, $category = null, $sub_category = null, $child_category = null)
    {
        // use with route collections
        $level = '';
        $category_id = $sub_category_id = $child_category_id = null;
        if ($category && $sub_category && $child_category) {
            $level = 'child';
            $child_category_id = ChildCategory::where(['slug' => $child_category, 'status' => 'Active'])->where('status', 'Active')->first();
        } else if ($category && $sub_category && !$child_category) {
            $level = 'sub';
            $sub_category_id = SubCategory::where(['slug' => $sub_category, 'status' => 'Active'])->first();
        } else if ($category && !$sub_category && !$child_category) {
            $level = 'main';
            $category_id = Category::where(['slug' => $category, 'status' => 'Active'])->first();
        }

        if ($category_id || $sub_category_id || $child_category_id) {
            $query = Product::query()->where('status', $this->status['Active']);
            switch ($level) {
                case 'main':
                    $data['main_category'] = Category::where(['slug' => $category, 'status' => 'Active'])->first();
                    $data['categories'] = SubCategory::where(['category_id' => $data['main_category']->id, 'status' => 'Active'])->get()->toArray();
                    $data['image'] = $data['main_category']['image'];
                    $data['category_name'] = $data['main_category']['name'];
                    $data['category_desc'] = $data['main_category']['desc'];
                    $data['main_slug'] = $data['main_category']['slug'];
                    // $data['products'] = Product::where(['category_id' => $data['main_category']->id])->paginate(21);
                    $query->where(['category_id' => $data['main_category']->id]);
                    $data['is_product'] = false;
                    break;
                case 'sub':
                    $data['main_category'] = Category::where(['slug' => $category, 'status' => 'Active'])->first();
                    $data['sub_category'] = SubCategory::where(['slug' => $sub_category, 'status' => 'Active'])->first();
                    $data['categories'] = ChildCategory::where(['sub_category_id' => $data['sub_category']->id, 'status' => 'Active'])->get()->toArray();
                    $data['image'] = $data['sub_category']['image'];
                    $data['category_name'] = $data['sub_category']['name'];
                    $data['category_desc'] = $data['sub_category']['desc'];
                    $data['main_slug'] = $data['main_category']['slug'];
                    $data['sub_slug'] = $data['sub_category']['slug'];
                    // $data['products'] = Product::where(['sub_category' => $data['sub_category']->id])->paginate(21);
                    $query->where(['sub_category' => $data['sub_category']->id]);
                    $data['is_product'] = true;
                    break;
                case 'child':
                    $data['category'] = ChildCategory::where(['slug', $child_category, 'status' => 'Active'])->first();
                    $data['is_product'] = true;
                    break;
                default:
                    $products = Product::where('status', $this->status['Active'])->paginate(21);
            }

            if ($request->has('sort')) {
                if ($request->sort === 'price_low_high') {
                    $query->orderBy('price');
                } elseif ($request->sort === 'price_high_low') {
                    $query->orderByDesc('price');
                } elseif ($request->sort === 'newest') {
                    $query->orderByDesc('created_at');
                }
            }
            $data['products'] = $query->paginate(21);

            return view('web.pages.collections', $data);
        } else {
            return view('web.pages.404');
        }
    }

    // cloned methods of myweightloss
    public function account()
    {
        $data['user'] = auth()->user() ?? [];
        return view('web.pages.account', $data);
    }

    public function wishlist()
    {
        $data['user'] = auth()->user() ?? [];
        return view('web.pages.wishlist', $data);
    }

    public function works()
    {
        $data['user'] = auth()->user() ?? [];
        return view('web.pages.works', $data);
    }

    public function faq()
    {
        $data['user'] = auth()->user() ?? [];
        return view('web.pages.faq', $data);
    }

    public function categories()
    {
        $data['user'] = auth()->user() ?? [];
        return view('web.pages.categories', $data);
    }

    public function categorydetail()
    {
        $data['user'] = auth()->user() ?? [];
        return view('web.pages.categorydetail', $data);
    }

    public function skincare()
    {
        $data['user'] = auth()->user() ?? [];
        $sub_category_id = SubCategory::where('slug', 'skin-care')->first()->id;
        $data['products'] = Product::where(['sub_category' => $sub_category_id, 'status' => $this->status['Active']])->get();
        return view('web.pages.skincare', $data);
    }

    public function diabetes()
    {
        $data['user'] = auth()->user() ?? [];
        $sub_category_id = SubCategory::where('slug', 'diabetes')->first()->id;
        $data['products'] = Product::where(['sub_category' => $sub_category_id])->where('status', $this->status['Active'])->get();
        return view('web.pages.diabetes', $data);
    }

    public function sleep()
    {
        $data['user'] = auth()->user() ?? [];
        $sub_category_id = SubCategory::where('slug', 'sleep')->first()->id;
        $data['products'] = Product::where('sub_category', $sub_category_id)->where('status', $this->status['Active'])->get();
        return view('web.pages.sleep', $data);
    }

    public function payment(Request $request)
    {
        // dd($request->all());
        $user = auth()->user() ?? [];
        $data = $request->all();
        $order_ids = $request->input('order_id.order_id', []);
        // dd($order_ids);

        if (!empty($order_ids)) {
            $order = Order::whereIn('id', $order_ids)->get();

            foreach ($order as $order) {
                $order->update([
                    'user_id'       => $user->id ?? 'guest',
                    'email'         => $request->email,
                    'note'          => $request->note,
                    'shiping_cost'  => $request->shiping_cost,
                    'coupon_code'   => $request->coupon_code ?? null,
                    'coupon_value'  => $request->coupon_value ?? null,
                    'total_ammount' => $request->total_ammount ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),

                ]);
            }

            // dd($order);
            if ($order) {
                $order_details = [];
                $index = 0;
                $order_for = 'despensory';
                foreach ($request->order_details['product_id'] as $key => $ids) {
                    if (strpos($ids, '_') !== false) {
                        [$pro_id, $variant_id] = explode('_', $ids);
                    } else {
                        $pro_id = $ids;
                        $variant_id = NULL;
                    }
                    $consultaion_type = 'one_over';

                    foreach (session('consultations') ?? [] as $key => $value) {
                        if ($key == $pro_id || strpos($key, ',') !== false && in_array($pro_id, explode(',', $key))) {
                            if (isset(session('consultations')[$key])) {
                                $consultaion_type = session('consultations')[$key]['type'];
                                $generic_consultation = (isset(session('consultations')[$key]['gen_quest_ans'])) ? json_encode(session('consultations')[$key]['gen_quest_ans'], true) : NULL;
                                $product_consultation = (isset(session('consultations')[$key]['pro_quest_ans'])) ? json_encode(session('consultations')[$key]['pro_quest_ans'], true) : NULL;
                                if ($product_consultation != '""') {
                                    $order_for = 'doctor';
                                }
                                break;
                            }
                        }
                    }
                    if ($variant_id) {
                        $variant = ProductVariant::find($variant_id);
                        $vart_type = explode(';', $variant->title);
                        $vart_value = explode(';', $variant->value);
                        $var_info = '';
                        foreach ($vart_type as $key => $type) {
                            $var_info .= "<b>$type:</b> {$vart_value[$key]}";
                            if ($key < count($vart_type) - 1) {
                                $var_info .= ', ';
                            }
                        }
                    }

                    $order_details[] = [
                        'product_id' => $pro_id,
                        'variant_id' => $variant_id ?? Null,
                        'variant_details' => $var_info ?? Null,
                        'weight' => Product::find($pro_id)->weight,
                        'order_id' => $order->id,
                        'product_price' => $request->order_details['product_price'][$index],
                        'product_name' => $request->order_details['product_name'][$index],
                        'product_qty' => $request->order_details['product_qty'][$index],
                        'generic_consultation' => $generic_consultation ?? NULL,
                        'product_consultation' => $product_consultation ?? NULL,
                        'consultation_type' => $consultaion_type ?? NULL,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $index++;
                }
                // dd($order_details);

                // Update or create OrderDetail records
                foreach ($order_details as $detail) {
                    $inserted =  OrderDetail::updateOrCreate(
                        ['order_id' => $detail['order_id']],
                        $detail
                    );
                }
                // dd ($order_detail_update);

                Order::where(['id' => $order->id])->latest('created_at')->first()
                    ->update(['order_for' => $order_for]);


                // $inserted =  OrderDetail::insert($order_details);

                // dd($request->all());
                if ($inserted) {
                    $shipping_details[] = [
                        'order_id' => $order->id,
                        'user_id' => $user->id ?? '',
                        'cost' => $request->shiping_cost,
                        'method' => $request->shipping_method,
                        'old_address' => $request->old_address ?? 'no',
                        'firstName' => $request->firstName,
                        'lastName' => $request->lastName,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'address2' => $request->address2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->zip_code,
                    ];
                    // $shiping =  ShipingDetail::create($shipping_details);
                    foreach ($shipping_details as $detail) {
                        $shiping =  ShipingDetail::updateOrCreate(
                            ['order_id' => $detail['order_id']],
                            $detail
                        );
                    }
                    // dd($shiping);
                    if ($shiping) {
                        session()->put('order_id', $order->id);
                        $payable_ammount = $request->total_ammount * 100;
                        $productName = 'Pharmacy 4U';
                        $productDescription = 'Pharmacy 4U';
                        $full_name = $request->firstName . ' ' . $request->lastName;

                        // Obtain Access Token
                        $accessToken = $this->getAccessToken();
                        // Prepare POST fields for creating an order
                        $postFields = [
                            'amount'              => $payable_ammount,
                            'customerTrns'        => $productDescription,
                            'customer'            => [
                                'email'       => $request->email,
                                'fullName'    => $full_name,
                                'phone'       => $request->phone,
                                'countryCode' => 'GB', // United Kingdom country code
                                'requestLang' => 'en-GB', // Request language set to English (United Kingdom)
                            ],
                            'paymentTimeout'      => 1800,
                            'preauth'             => false,
                            'allowRecurring'      => false,
                            'maxInstallments'     => 0,
                            'paymentNotification' => true,
                            'disableExactAmount'  => false,
                            'disableCash'         => false,
                            'disableWallet'       => false,
                            'sourceCode'          => '1503',
                            "merchantTrns" => "Short description of items/services purchased by customer",
                            "tags" =>
                            [
                                "tags for grouping and filtering the transactions",
                                "this tag can be searched on VivaWallet sales dashboard",
                                "Sample tag 1",
                                "Sample tag 2",
                                "Another string"
                            ],
                        ];

                        $response = $this->sendHttpRequest('https://api.vivapayments.com/checkout/v2/orders', $postFields, $accessToken);
                        $responseData = json_decode($response, true);

                        if (isset($responseData['orderCode'])) {

                            $orderCode = $responseData['orderCode'];
                            $temp_code = random_int(00000, 99999); //tesitng ..
                            $temp_transetion = 'testing'; // testing purspose
                            $payment_detials = [
                                'order_id' => $order->id,
                                'orderCode' => ($this->ENV == 'Live') ?  $orderCode : $temp_code,
                                'amount' => $request->total_ammount
                            ];

                            $payment_init =  PaymentDetail::create($payment_detials);
                            Order::where('id', $order->id)->update([
                                'payment_id' => $payment_init->id,
                                'payment_status' => 'Paid',
                                'status' =>         'Received',
                            ]);
                            if ($payment_init) {
                                $redirectUrl = ($this->ENV == 'Live') ? "https://www.vivapayments.com/web/checkout?ref={$orderCode}" : url("/Completed-order?t=$temp_transetion&s=$temp_code&lang=en-GB&eventId=0&eci=1");
                                return response()->json(['redirectUrl' => $redirectUrl]);
                            }
                        }
                    }
                }
            }
        }

        if (empty($order_ids)) {

            // dd($request->all());
            $order =  Order::create([
                'user_id'        => $user->id ?? 'guest',
                'email'          => $request->email,
                'note'           => $request->note,
                'shiping_cost'   => $request->shiping_cost,
                'coupon_code'    => $request->coupon_code ?? Null,
                'coupon_value'   => $request->coupon_value ?? Null,
                'total_ammount'  => $request->total_ammount ?? Null,
            ]);

            if ($order) {
                $order_details = [];
                $index = 0;
                $order_for = 'despensory';
                foreach ($request->order_details['product_id'] as $key => $ids) {
                    if (strpos($ids, '_') !== false) {
                        [$pro_id, $variant_id] = explode('_', $ids);
                    } else {
                        $pro_id = $ids;
                        $variant_id = NULL;
                    }
                    $consultaion_type = 'one_over';

                    foreach (session('consultations') ?? [] as $key => $value) {
                        if ($key == $pro_id || strpos($key, ',') !== false && in_array($pro_id, explode(',', $key))) {
                            if (isset(session('consultations')[$key])) {
                                $consultaion_type = session('consultations')[$key]['type'];
                                $generic_consultation = (isset(session('consultations')[$key]['gen_quest_ans'])) ? json_encode(session('consultations')[$key]['gen_quest_ans'], true) : NULL;
                                $product_consultation = (isset(session('consultations')[$key]['pro_quest_ans'])) ? json_encode(session('consultations')[$key]['pro_quest_ans'], true) : NULL;
                                if ($product_consultation != '""') {
                                    $order_for = 'doctor';
                                }
                                break;
                            }
                        }
                    }
                    if ($variant_id) {
                        $variant = ProductVariant::find($variant_id);
                        $vart_type = explode(';', $variant->title);
                        $vart_value = explode(';', $variant->value);
                        $var_info = '';
                        foreach ($vart_type as $key => $type) {
                            $var_info .= "<b>$type:</b> {$vart_value[$key]}";
                            if ($key < count($vart_type) - 1) {
                                $var_info .= ', ';
                            }
                        }
                    }

                    $order_details[] = [
                        'product_id' => $pro_id,
                        'variant_id' => $variant_id ?? Null,
                        'variant_details' => $var_info ?? Null,
                        'weight' => Product::find($pro_id)->weight,
                        'order_id' => $order->id,
                        'product_price' => $request->order_details['product_price'][$index],
                        'product_name' => $request->order_details['product_name'][$index],
                        'product_qty' => $request->order_details['product_qty'][$index],
                        'generic_consultation' => $generic_consultation ?? NULL,
                        'product_consultation' => $product_consultation ?? NULL,
                        'consultation_type' => $consultaion_type ?? NULL,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $index++;
                }

                Order::where(['id' => $order->id])->latest('created_at')->first()
                    ->update(['order_for' => $order_for]);
                $inserted =  OrderDetail::insert($order_details);
                if ($inserted) {
                    $shipping_details = [
                        'order_id' => $order->id,
                        'user_id' => $user->id ?? '',
                        'cost' => $request->shiping_cost,
                        'method' => $request->shipping_method,
                        'old_address' => $request->old_address ?? 'no',
                        'firstName' => $request->firstName,
                        'lastName' => $request->lastName,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'address2' => $request->address2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->zip_code,
                    ];
                    $shiping =  ShipingDetail::create($shipping_details);
                    if ($shiping) {
                        session()->put('order_id', $order->id);
                        $payable_ammount = $request->total_ammount * 100;
                        $productName = 'Pharmacy 4U';
                        $productDescription = 'Pharmacy 4U';
                        $full_name = $request->firstName . ' ' . $request->lastName;

                        // Obtain Access Token
                        $accessToken = $this->getAccessToken();
                        // Prepare POST fields for creating an order
                        $postFields = [
                            'amount'              => $payable_ammount,
                            'customerTrns'        => $productDescription,
                            'customer'            => [
                                'email'       => $request->email,
                                'fullName'    => $full_name,
                                'phone'       => $request->phone,
                                'countryCode' => 'GB', // United Kingdom country code
                                'requestLang' => 'en-GB', // Request language set to English (United Kingdom)
                            ],
                            'paymentTimeout'      => 1800,
                            'preauth'             => false,
                            'allowRecurring'      => false,
                            'maxInstallments'     => 0,
                            'paymentNotification' => true,
                            'disableExactAmount'  => false,
                            'disableCash'         => false,
                            'disableWallet'       => false,
                            'sourceCode'          => '1503',
                            "merchantTrns" => "Short description of items/services purchased by customer",
                            "tags" =>
                            [
                                "tags for grouping and filtering the transactions",
                                "this tag can be searched on VivaWallet sales dashboard",
                                "Sample tag 1",
                                "Sample tag 2",
                                "Another string"
                            ],
                        ];

                        $response = $this->sendHttpRequest('https://api.vivapayments.com/checkout/v2/orders', $postFields, $accessToken);
                        $responseData = json_decode($response, true);

                        if (isset($responseData['orderCode'])) {

                            $orderCode = $responseData['orderCode'];
                            $temp_code = random_int(00000, 99999); //tesitng ..
                            $temp_transetion = 'testing'; // testing purspose
                            $payment_detials = [
                                'order_id' => $order->id,
                                'orderCode' => ($this->ENV == 'Live') ?  $orderCode : $temp_code,
                                'amount' => $request->total_ammount
                            ];

                            $payment_init =  PaymentDetail::create($payment_detials);
                            Order::where('id', $order->id)->update(['payment_id' => $payment_init->id]);
                            if ($payment_init) {
                                $redirectUrl = ($this->ENV == 'Live') ? "https://www.vivapayments.com/web/checkout?ref={$orderCode}" : url("/Completed-order?t=$temp_transetion&s=$temp_code&lang=en-GB&eventId=0&eci=1");
                                return response()->json(['redirectUrl' => $redirectUrl]);
                            }
                        }
                    }
                }
            }
        }
    }


    private function getAccessToken()
    {
        try {
            // Viva Wallet API credentials
            $username = 'dkwrul3i0r4pwsgkko3nr8c4vs0h5yn5tunio398ik403.apps.vivapayments.com'; //client id
            $password = 'BuLY8U1pEsXNPBgaqz98y54irE7OpL'; // secrit key
            $credentials = base64_encode($username . ':' . $password);

            // Make an HTTP request to obtain an access token
            $response = Http::asForm()->withHeaders([
                'Authorization' => 'Basic ' . $credentials,
            ])->post('https://accounts.vivapayments.com/connect/token', [
                'grant_type' => 'client_credentials',
            ]);

            // Check if the request was successful (status code 2xx)
            if ($response->successful()) {
                return $response->json('access_token');
            } else {
                // Log the error response for further investigation
                Log::error('Error response: ' . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            // Log any exceptions that occurred during the request
            Log::error('Exception: ' . $e->getMessage());
            return null;
        }
    }

    private function sendHttpRequest($url, $postFields, $accessToken)
    {
        // Make an HTTP request with Laravel HTTP client
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'  => 'application/json',
        ])->post($url, $postFields);

        // Return the response body
        return $response->body();
    }


    // response example  url : https://onlinepharmacy-4u.co.uk/Completed-order?t=8cbe1c22-08bf-46f7-815a-b4edf9c76c22&s=7217646205950618&lang=en-GB&eventId=0&eci=1
    public function completed_order(Request $request)
    {

        $transetion_id = $request->query('t');
        $orderCode = $request->query('s');
        $payment_detail = PaymentDetail::where('orderCode', $orderCode)->firstOrFail();
        if ($payment_detail) {
            if ($this->ENV == 'Live') {
                $accessToken = $this->getAccessToken();
                $url = "https://api.vivapayments.com/checkout/v2/transactions/{$transetion_id}";

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ])->get($url);

                $responseData = json_decode($response, true);
                $update_payment = [
                    'transactionId' => $transetion_id,
                    'fullName' => $responseData['fullName'],
                    'email' => $responseData['email'],
                    'cardNumber' => $responseData['cardNumber'],
                    'statusId' => $responseData['statusId'],
                    'insDate' => $responseData['insDate'],
                    'amount' => $responseData['amount'],
                ];
            } else {
                $update_payment = [
                    'transactionId' => $transetion_id,
                    'fullName' => 'test',
                    'email' => 'testing@gmail.com',
                    'cardNumber' => '34234test34234',
                    'statusId' => 'F',
                    'insDate' => now(),
                ];
            }
            $payment =   PaymentDetail::where('id', $payment_detail->id)->update($update_payment);

            $payment_detail = PaymentDetail::find($payment_detail->id);
            $order = Order::with('orderdetails', 'orderdetails.product')->where('id', $payment_detail->order_id)->latest('created_at')->first();

            if ($order) {
                $user = auth()->user() ?? [];
                $order->update(['payment_status' => 'Paid']);
                $name = $order->shipingdetails->firstName;
                $order_for = [user_roles('1'), ($order->order_for == 'doctor') ? user_roles('3') : user_roles('2')];
                $users = User::where('status', 1)->WhereIn('role', $order_for)->get();
                Notification::send($users, new UserOrderNotification($order));
                Mail::to($order->shipingdetails->email)->send(new OrderConfirmation($order));
                Session::flush();
                if ($user) {
                    Auth::logout();
                    Auth::login($user);
                }
                echo "<script>
                if (window.self !== window.top) {
                    window.top.location.href = '" . route('thankYou', ['n' => $name]) . "';
                } else {
                    window.location.href = '" . route('thankYou', ['n' => $name]) . "';
                }
                </script>";
                exit;
            } else {
                dd('Order could not developer');
            }
        } else {
            dd('No Payment details found.');
        }
    }

    public function unsuccessful_order(Request $request)
    {
        $transetion_id = $request->query('t');
        $orderCode = $request->query('s');
        $payment_detail = PaymentDetail::where('orderCode', $orderCode)->firstOrFail();
        if ($payment_detail) {
            $accessToken = $this->getAccessToken();
            $url = "https://api.vivapayments.com/checkout/v2/transactions/{$transetion_id}";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->get($url);

            $responseData = json_decode($response, true);
            $update_payment = [
                'transactionId' => $transetion_id,
                'fullName' => $responseData['fullName'],
                'email' => $responseData['email'],
                'cardNumber' => $responseData['cardNumber'],
                'statusId' => $responseData['statusId'],
                'insDate' => $responseData['insDate'],
                'amount' => $responseData['amount'],
                'status' => 'Fail',
            ];
            $payment =   PaymentDetail::where('id', $payment_detail->id)->update($update_payment);

            $payment_detail = PaymentDetail::find($payment_detail->id);
            $order = Order::where('id', $payment_detail->order_id)->latest('created_at')->first();

            if ($order) {
                if (Auth::check()) {
                    $user = Auth()->user() ?? [];
                    Session::flush();
                    Auth::logout();
                    Auth::login($user);
                    if (Auth()->user()) {
                        $name = $order->shipingdetails->firstName;
                        echo "<script>
                            if (window.self !== window.top) {
                                window.top.location.href = '" . route('transetionFail', ['n' => $name]) . "';
                            } else {
                                window.location.href = '" . route('transetionFail', ['n' => $name]) . "';
                            }
                        </script>";
                        exit;
                    } else {
                        dd('Authentication failed. Please try again.');
                    }
                } else {
                    Session::flush();
                    $name = $order->shipingdetails->firstName;
                    echo "<script>
                        if (window.self !== window.top) {
                            window.top.location.href = '" . route('transetionFail', ['n' => $name]) . "';
                        } else {
                            window.location.href = '" . route('transetionFail', ['n' => $name]) . "';
                        }
                    </script>";
                    exit;
                }
            } else {
                dd('Order could not  found.');
            }
        } else {
            dd('No Payment details found.');
        }
    }

    public function get_related_products($product)
    {
        $category = $product->category_id;
        $sub_category = $product->sub_category;
        $child_category = $product->child_category;
        $level = '';
        if ($category && $sub_category && $child_category) {
            $level = 'child';
        } else if ($category && $sub_category && !$child_category) {
            $level = 'sub';
        } else if ($category && !$sub_category && !$child_category) {
            $level = 'main';
        }

        switch ($level) {
            case 'main':
                $products = Product::where(['status' => $this->status['Active'], 'category_id' => $category])->where('id', '!=', $product->id)->latest('id')->get();
                break;
            case 'sub':
                $products = Product::where(['status' => $this->status['Active'], 'sub_category' => $sub_category])->where('id', '!=',  $product->id)->latest('id')->get();
                break;
            case 'child':
                $products = Product::where(['status' => $this->status['Active'], 'child_category' => $child_category])->where('id', '!=', $product->id)->latest('id')->get();
                break;
            default:
                $products = Product::where(['status' => $this->status['Active']])->get();
        }

        return $products ?? NULL;
    }

    public function get_category_slug($product_id)
    {
        $product = Product::find($product_id);
        $category = $product->category_id;
        $sub_category = $product->sub_category;
        $child_category = $product->child_category;
        $level = '';
        if ($category && $sub_category && $child_category) {
            $level = 'child';
        } else if ($category && $sub_category && !$child_category) {
            $level = 'sub';
        } else if ($category && !$sub_category && !$child_category) {
            $level = 'main';
        }

        switch ($level) {
            case 'main':
                $slug['main_category'] = Category::where(['id' => $category])->pluck('slug');
                break;
            case 'sub':
                $slug['sub_category'] = SubCategory::where(['id' => $sub_category])->pluck('slug');;
                break;
            case 'child':
                $slug['child_category'] = ChildCategory::where(['id' => $child_category])->pluck('slug');;
                break;
        }

        return $slug ?? NULL;
    }

    public function search(Request $request)
    {
        $data['string'] = $request->q;
        $category_id = Category::where('name', 'like', '%' . $data['string'] . '%')->pluck('id');
        $subCategory_id = SubCategory::where('name', 'like', '%' . $data['string'] . '%')->pluck('id');
        $childCategory_id = ChildCategory::where('name', 'like', '%' . $data['string'] . '%')->pluck('id');

        $data['products'] = Product::where(['status' => $this->status['Active']])->where('title', 'like', '%' . $data['string'] . '%')
            ->when(!$category_id->isEmpty(), function ($query) use ($category_id) {
                $query->orWhereIn('category_id', $category_id);
            })
            ->when(!$subCategory_id->isEmpty(), function ($query) use ($subCategory_id) {
                $query->orWhereIn('sub_category', $subCategory_id);
            })
            ->when(!$childCategory_id->isEmpty(), function ($query) use ($childCategory_id) {
                $query->orWhereIn('child_category', $childCategory_id);
            })
            ->paginate(20);

        $data['total'] = $data['products']->total();
        $data['currentPage'] = $data['products']->count();

        return view('web.pages.search', $data);
    }

    public function treatment(Request $request)
    {
        $ranges = [
            'a-e' => ['a', 'b', 'c', 'd', 'e'],
            'f-j' => ['f', 'g', 'h', 'i', 'j'],
            'k-o' => ['k', 'l', 'm', 'n', 'o'],
            'p-t' => ['p', 'q', 'r', 's', 't'],
            'u-z' => ['u', 'v', 'w', 'x', 'y', 'z'],
        ];

        $letters = $request->t ? $ranges[$request->t] : $ranges['a-e'];

        $data['products'] = Product::where(['status' => $this->status['Active']])->where(function ($query) use ($letters) {
            foreach ($letters as $letter) {
                $query->orWhere('title', 'like', $letter . '%');
            }
        })
            ->orderBy('title')
            ->paginate(100);
        $data['range'] = $request->t ?? 'a-e';

        return view('web.pages.treatment', $data);
    }

    public function conditions(Request $request)
    {
        $ranges = [
            'a-e' => ['a', 'b', 'c', 'd', 'e'],
            'f-j' => ['f', 'g', 'h', 'i', 'j'],
            'k-o' => ['k', 'l', 'm', 'n', 'o'],
            'p-t' => ['p', 'q', 'r', 's', 't'],
            'u-z' => ['u', 'v', 'w', 'x', 'y', 'z'],
        ];

        $letters = $request->t ? $ranges[$request->t] : $ranges['a-e'];

        $categories = Category::select('name', 'slug', 'image', 'slug AS url')
            ->where('status', 'Active')
            ->where(function ($query) use ($letters) {
                foreach ($letters as $letter) {
                    $query->orWhere('name', 'like', $letter . '%');
                }
            })
            ->whereHas('products');

        $subCategories = SubCategory::select(
            'sub_categories.name',
            'sub_categories.slug',
            'sub_categories.image',
            DB::raw("CONCAT(categories.slug, '/', sub_categories.slug) AS url")
        )
            ->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->where('sub_categories.status', 'Active')
            ->where(function ($query) use ($letters) {
                foreach ($letters as $letter) {
                    $query->orWhere('sub_categories.name', 'like', $letter . '%');
                }
            })
            ->whereHas('products')
            ->with('category');

        $childCategories = ChildCategory::select(
            'child_categories.name',
            'child_categories.slug',
            'child_categories.image',
            DB::raw("CONCAT(categories.slug, '/', sub_categories.slug, '/', child_categories.slug) AS url")
        )
            ->leftJoin('sub_categories', 'child_categories.sub_category_id', '=', 'sub_categories.id')
            ->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->where('child_categories.status', 'Active')
            ->where(function ($query) use ($letters) {
                foreach ($letters as $letter) {
                    $query->orWhere('child_categories.name', 'like', $letter . '%');
                }
            })
            ->whereHas('products');

        $data['conditions'] = $categories->union($subCategories)->union($childCategories)->orderBy('name')->get();
        $data['range'] = $request->t ?? 'a-e';

        return view('web.pages.conditions', $data);
    }

    public function generate_slug_existing()
    {
        // generate slugs for existing products
        $needSlugs = Product::where(['status' => $this->status['Active']])->where('slug', null)->get();

        foreach ($needSlugs as $slug) {
            $slug->update([
                'slug' => SlugService::createSlug(Product::class, 'slug', $slug->title)
            ]);
        }
        return 1;
    }

    public function generate_slug_variants_existing()
    {
        // generate slugs for existing product variants
        $needSlugs = ProductVariant::with('product')->where('slug', null)->get();

        foreach ($needSlugs as $slug) {
            $slug->update([
                'slug' => SlugService::createSlug(ProductVariant::class, 'slug', $slug->product->title . ' ' . $slug->value)
            ]);
        }
        return 1;
    }

    public function error_404()
    {
        return view('web.pages.404');
    }

    public function thank_you(Request $request)
    {
        // Retrieve user information if available
        $data['user'] = auth()->user() ?? [];

        // Retrieve other query parameters
        $name = $request->query('n');
        $data['name'] = $name ?? 'Guest';

        // Example of fetching or setting transaction details
        // These should be replaced with actual data retrieval logic
        $transactionId = ''; // Replace with the actual transaction ID
        $transactionTotal = ''; // Replace with the actual transaction total
        $currency = 'GBP'; // Replace with the actual currency

        // Add transaction details to the data array
        $data['transactionId'] = $transactionId;
        $data['transactionTotal'] = $transactionTotal;
        $data['currency'] = $currency;

        // Return the view with the data
        return view('web.pages.thankyou', $data);
    }


    public function transetion_fail(Request $request)
    {
        $data['user'] = auth()->user() ?? [];
        $name = $request->query('n');
        $data['name'] = $name ?? 'Guest';
        return view('web.pages.unsuccessful_order', $data);
    }

    public function store_human_form(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required',
            'title' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['user_id'] = $user->id ?? Null;

        if ($request->hasFile('file')) {
            $fileValidator = Validator::make($request->all(), [
                'file' => 'required',
            ]);

            if ($fileValidator->fails()) {
                return redirect()->back()->withErrors($fileValidator)->withInput();
            }

            $HumanRequestFormFile = $request->file('file');
            $HumanRequestFormFileName = time() . '_' . uniqid('', true) . '.' . $HumanRequestFormFile->getClientOriginalExtension();
            $HumanRequestFormFile->storeAs('human_request_file/', $HumanRequestFormFileName, 'public');
            $data['file'] = 'human_request_file/' . $HumanRequestFormFileName;
        }

        $question = HumanRequestForm::updateOrCreate(
            ['id' => $request->id ?? null],
            $data
        );

        if ($question->id) {
            $message = "Query is submitted successfully";
            return redirect()->back()->with(['msg' => $message]);
        }
    }


    public function successfully_refunded(Request $request)
    {
        return 'ammount is refunded';
    }


    public function sitemap()
    {

        return view('web.pages.sitemap');
    }
    public function pagesitemap()
    {

        return view('web.pages.pagesitemap');
    }
    public function productsitemap()
    {

        return view('web.pages.productsitemap');
    }
    public function categoriessitemap()
    {

        return view('web.pages.categoriessitemap');
    }
}
