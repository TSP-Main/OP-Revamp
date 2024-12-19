<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\FaqProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Question;
use App\Models\QuestionMapping;
use App\Models\SubCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Traits\MenuCategoriesTrait;
use App\Models\ProductNotification;

class ProductDetailsController extends Controller
{
    use MenuCategoriesTrait;
    public function shop(Request $request, $category = null, $sub_category = null, $child_category = null)
    {
        $this->shareMenuCategories();
        // Get consultation data
        $slug = $this->getSlug($category, $sub_category, $child_category);
        $data['pre_add_to_cart'] = $this->checkConsultation($slug) ? 'yes' : 'no';

        // Get category details
        $category_detail = $this->getCategoryDetail($category, $sub_category, $child_category);

        // Get products based on category level or default sorting
        $products = $this->getProducts($category_detail, $request, $category, $sub_category, $child_category);

        // Prepare additional data
        $data['products'] = $products;
        $data['categories_list'] = Category::where('publish', 'Publish')->latest('id')->get();

        return view('web.pages.shop', $data);
    }

    /**
     * Create a slug array from the given categories.
     */
    private function getSlug($category, $sub_category, $child_category)
    {
        return [
            "main_category" => $category,
            "sub_category" => $sub_category,
            "child_category" => $child_category
        ];
    }

    /**
     * Check if the consultation is found and has answers.
     */
    private function checkConsultation($slug)
    {
        $consultations = session('consultations') ?? [];
        foreach ($consultations as $consultation) {
            if (isset($consultation['slug']) && $slug == $consultation['slug']) {
                if ($consultation['gen_quest_ans'] != '' && $consultation['pro_quest_ans'] != '') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Get the category details based on the category level.
     */
    private function getCategoryDetail($category, $sub_category, $child_category)
    {
        if ($category && $sub_category && $child_category) {
            return ChildCategory::where('slug', $child_category)->first();
        } elseif ($category && $sub_category && !$child_category) {
            return SubCategory::where('slug', $sub_category)->first();
        } elseif ($category && !$sub_category && !$child_category) {
            return Category::where('slug', $category)->first();
        }
        return null;
    }

    /**
     * Get products based on the category level or default sorting.
     */
    private function getProducts($category_detail, Request $request, $category, $sub_category, $child_category)
    {
        //        $this->shareMenuCategories();
        if ($category_detail) {
            if ($category && $sub_category && $child_category) {

                return Product::where(['status' => $this->status['Active'], 'child_category' => $category_detail->id])->paginate(100);
            } elseif ($category && $sub_category && !$child_category) {
                return Product::where(['status' => $this->status['Active'], 'sub_category' => $category_detail->id])->paginate(100);
            } elseif ($category && !$sub_category && !$child_category) {
                return Product::where(['status' => $this->status['Active'], 'category_id' => $category_detail->id])->paginate(100);
            }
        }

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

        return $query->paginate(21);
    }

    public function show_products(Request $request, $category = null, $sub_category = null, $child_category = null)
    {
        $this->shareMenuCategories();
        // Get consultation data
        $slug = $this->getSlug($category, $sub_category, $child_category);
        $data['pre_add_to_cart'] = $this->checkConsultation($slug) ? 'yes' : 'no';

        // Get category details
        $category_detail = $this->getCategoryDetailWithStatus($category, $sub_category, $child_category);

        if ($category_detail) {
            // Get products based on category level
            $products = $this->getProducts($category_detail, $request, $category, $sub_category, $child_category);

            // Collect specific product IDs based on a condition
            $data['products'] = $products;
            $data['product_ids'] = $this->getProductTemplateIds($products);

            // Prepare additional data
            $data['categories_list'] = Category::where('publish', 'Publish')->latest('id')->get();
            $data['category_detail'] = $category_detail;

            return view('web.pages.products_list', $data);
        } else {
            return view('web.pages.404');
        }
    }

    /**
     * Get the category details based on the category level with active status.
     */
    private function getCategoryDetailWithStatus($category, $sub_category, $child_category)
    {
        if ($category && $sub_category && $child_category) {
            return ChildCategory::where('slug', $child_category)->where('status', 'Active')->first();
        } elseif ($category && $sub_category && !$child_category) {
            return SubCategory::where('slug', $sub_category)->where('status', 'Active')->first();
        } elseif ($category && !$sub_category && !$child_category) {
            return Category::where('slug', $category)->where('status', 'Active')->first();
        }
        return null;
    }

    /**
     * Get product template IDs based on a specific condition.
     */
    private function getProductTemplateIds($products)
    {
        $product_template_2_ids = [];
        foreach ($products as $item) {
            if ($item->product_template == config('constants.PRESCRIPTION_MEDICINE') || $item->question_risk == '2') {
                $product_template_2_ids[] = $item->id;
            }
        }
        return implode(',', $product_template_2_ids);
    }

    public function product_detail($slug)
    {
        $this->shareMenuCategories();
        $data['user'] = auth()->user() ?? [];
        // $data['product'] = Product::with('category:id,name,slug', 'sub_cat:id,name,slug', 'child_cat:id,name,slug', 'variants')->findOrFail($request->id);
        $data['product'] = Product::with('productAttributes:id,product_id,image', 'category:id,name,slug', 'sub_cat:id,name,slug', 'child_cat:id,name,slug', 'variants')
            ->where('slug', $slug)->where('status', $this->status['Active'])->firstOrFail();
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

    public function notify(Request $request, $productId)
    {
        // if (!auth()->check()) {
        //     return redirect()->route('sign_in_form')->with('error', 'You need to be logged in to receive notifications.');
        // }


        $email = $request->input('email');
        // Validate and fetch user email
        $user = auth()->user();
        // $request->validate([
        //     'email' => $email ?? $user->email,
        // ]);

        // Check if the product exists
        $product = Product::findOrFail($productId);

        // Create or update the notification record
        ProductNotification::updateOrCreate(
            [
                'user_id' => $user->id ?? null,
                'product_id' => $productId,
            ],
            [
                'email' => $user->email ?? $email,
            ]
        );

        return back()->with('success', 'You will be notified when this product is back in stock.');
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

        //switches
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


    public function product_question(Request $request)
    {
        $this->shareMenuCategories();
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

            return view('web.pages.product_question', $data);
        } else {
            session()->put('intended_url', 'fromConsultation');
            return redirect()->route('register');
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

    public function treatment(Request $request)
    {
        $this->shareMenuCategories(); // from MenuCategoryTrait
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

    public function generateSlugExisting()
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

    public function generateSlugVariantsExisting()
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
}
