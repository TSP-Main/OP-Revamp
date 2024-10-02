<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\MenuCategoriesTrait;

// models ...
use App\Models\Category;
use App\Models\Product;
use App\Models\FeaturedProduct;

class HomeController extends Controller
{
    use MenuCategoriesTrait;
    //index
    public function index()
    {
        $this->shareMenuCategories(); // from MenuCategoryTrait
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

    public function help()
    {
        $this->shareMenuCategories();
        return view('web.pages.help');
    }

    public function order_status()
    {
        $this->shareMenuCategories();
        return view('web.pages.order_status');
    }

    public function delivery()
    {
        $this->shareMenuCategories();
        return view('web.pages.delivery');
    }

    public function returns()
    {
        $this->shareMenuCategories();
        return view('web.pages.returns');
    }

    public function complaints()
    {
        $this->shareMenuCategories();
        return view('web.pages.complaints');
    }

    public function policy()
    {
        $this->shareMenuCategories();
        return view('web.pages.policy');
    }

    public function prescribers()
    {
        $this->shareMenuCategories();
        return view('web.pages.prescribers');
    }

    public function about(Request $request)
    {
        $this->shareMenuCategories(); // from MenuCategoryTrait
        return view('web.pages.about');
    }

    public function howItWork()
    {
        $this->shareMenuCategories();
        return view('web.pages.works');
    }

    public function product_information()
    {
        $this->shareMenuCategories();
        return view('web.pages.product_information');
    }

    public function responsible_pharmacist()
    {
        $this->shareMenuCategories();
        return view('web.pages.responsible_pharmacist');
    }

    public function modern_slavery_act()
    {
        $this->shareMenuCategories();
        return view('web.pages.modern_slavery_act');
    }

    public function opioid_policy()
    {
        $this->shareMenuCategories();
        return view('web.pages.opioid_policy');
    }

    public function privacy_and_cookies_policy(Request $request)
    {
        return view('web.pages.privacy_and_cookies_policy');
    }

    public function terms_and_conditions()
    {
        $this->shareMenuCategories();
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
