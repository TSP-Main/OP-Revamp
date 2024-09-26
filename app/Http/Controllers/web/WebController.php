<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\otpVerifcation;
use Illuminate\Support\Facades\Session;
use Deyjandi\VivaWallet\Enums\RequestLang;
use Deyjandi\VivaWallet\Enums\PaymentMethod;
use Deyjandi\VivaWallet\Facades\VivaWallet;
use Deyjandi\VivaWallet\Customer;
use Deyjandi\VivaWallet\Payment;

// models ...
use App\Models\Category;
use App\Models\Transaction;
use App\Models\UserBmi;
use App\Models\UserConsultation;

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
}
