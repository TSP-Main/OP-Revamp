<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\otpVerifcation;

// models ...
use App\Models\Category;
use App\Models\Product;
use App\Models\FeaturedProduct;

class HomeController extends Controller
{
    private $menu_categories;
    protected $status;

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
    }

    public function index(Request $request)
    {
        $data['user'] = auth()->user() ?? [];
        $featuredProducts = FeaturedProduct::with('product')->latest('id')->take(8)->get();

        $products = [];
        foreach ($featuredProducts as $featuredProduct) {
            $products[] = $featuredProduct->product;
        }

        $data['products'] = $products;
        return view('web.pages.home', $data);
    }
    public function human_request_form(Request $request)
    {
        $data['user'] = auth()->user() ?? [];
        $data['products'] = Product::where(['status' => $this->status['Active']])->latest()->take(6)->get();
        return view('web.pages.human_request_form', $data);
    }
    public function questions_preview(Request $request)
    {
        $data['user'] = auth()->user() ?? [];
        return view('web.pages.questions_preview');
    }

    public function blogs(Request $request)
    {
        return view('web.pages.blogs');
    }


    public function blog_details(Request $request)
    {
        return view('web.pages.blog_details');
    }

    public function contact_us(Request $request)
    {
        return view('web.pages.contact');
    }

    public function about_us(Request $request)
    {
        return view('web.pages.about_us');
    }

    public function term(Request $request)
    {
        return view('web.pages.term');
    }

    public function privacy(Request $request)
    {
        return view('web.pages.privacy');
    }

    public function deliveryReturns(Request $request)
    {
        return view('web.pages.deliveryReturns');
    }

    public function help(Request $request)
    {
        return view('web.pages.help');
    }

    public function order_status(Request $request)
    {
        return view('web.pages.order_status');
    }

    public function delivery(Request $request)
    {
        return view('web.pages.delivery');
    }

    public function returns(Request $request)
    {
        return view('web.pages.returns');
    }

    public function complaints(Request $request)
    {
        return view('web.pages.complaints');
    }

    public function policy(Request $request)
    {
        return view('web.pages.policy');
    }

    public function prescribers(Request $request)
    {
        return view('web.pages.prescribers');
    }

    public function about(Request $request)
    {
        return view('web.pages.about');
    }

    public function how_it_work(Request $request)
    {
        return view('web.pages.works');
    }

    public function product_information(Request $request)
    {
        return view('web.pages.product_information');
    }

    public function responsible_pharmacist(Request $request)
    {
        return view('web.pages.responsible_pharmacist');
    }

    public function modern_slavery_act(Request $request)
    {
        return view('web.pages.modern_slavery_act');
    }

    public function opioid_policy(Request $request)
    {
        return view('web.pages.opioid_policy');
    }

    public function privacy_and_cookies_policy(Request $request)
    {
        return view('web.pages.privacy_and_cookies_policy');
    }

    public function terms_and_conditions(Request $request)
    {
        return view('web.pages.terms_and_conditions');
    }

    public function acceptable_use_policy(Request $request)
    {
        return view('web.pages.acceptable_use_policy');
    }

    public function editorial_policy(Request $request)
    {
        return view('web.pages.editorial_policy');
    }

    public function dispensing_frequencies(Request $request)
    {
        return view('web.pages.dispensing_frequencies');
    }

    public function identity_verification(Request $request)
    {
        return view('web.pages.identity_verification');
    }

    public function clinic(Request $request)
    {
        return view('web.pages.clinic');
    }
}
