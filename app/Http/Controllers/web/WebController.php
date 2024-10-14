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
use App\Models\Transaction;
use App\Models\UserBmi;
use App\Models\UserConsultation;
use App\Traits\MenuCategoriesTrait;

class WebController extends Controller
{
    use MenuCategoriesTrait;
    // cloned methods of myweightloss
    public function account()
    {
        $this->shareMenuCategories();
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
