<?php

namespace App\Http\Controllers\web;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShipingDetail;

class CartController extends Controller
{
    private $menu_categories;

    public function __construct()
    {
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

    public function cart()
    {
        $data['cartContent'] = Cart::content();
        return view('web.pages.cart', $data);
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        $variant_id =  $request->variantId ?? NULL;
        $quantity =  $request->quantity ?? 1;
        $cartItems = collect(Cart::content());
        $prod_id = $request->id;

        $variant = null;
        if ($variant_id) {
            $variant = ProductVariant::find($variant_id);
        }

        $item = $cartItems->filter(function ($value) use ($prod_id) {
            return strpos($value->id, $prod_id) !== false;
        });

        if (($product->min_buy && $quantity < $product->min_buy && count($item) == 0)) {
            return response()->json([
                'status' => false,
                'message' => 'Buy minimum ' . $product->min_buy . ' quantity'
            ]);
        }

        if (count($item) == 0) {
            if ($product->max_buy && $quantity > $product->max_buy) {
                return response()->json([
                    'status' => false,
                    'message' => 'Max buy ' . $product->max_buy . ' quantity'
                ]);
            }
        } else {
            $sumOfQty = $item->sum('qty');
            if ($product->max_buy && ($quantity + $sumOfQty > $product->max_buy)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Max buy ' . $product->max_buy . ' quantity.' . ' you already add ' . $sumOfQty
                ]);
            }
        }

        if ($variant) {
            $vart_type = explode(';', $variant->title);
            $vart_value = explode(';', $variant->value);
            $var_info = '<br>';
            foreach ($vart_type as $key => $type) {
                $var_info .= "<b>$type:</b> {$vart_value[$key]}";
                if ($key < count($vart_type) - 1) {
                    $var_info .= ', ';
                }
            }
            $variant['new_var_info'] = $var_info;
            Cart::add($product->id . '_' . $variant->id, $product->title , $quantity, $variant->price, ['productImage' => (!empty($product->main_image)) ? $product->main_image : '', 'variant_info' => $variant, 'slug' => $product->slug]);
        } else {
            Cart::add($product->id, $product->title, $quantity, $product->price, ['productImage' => (!empty($product->main_image)) ? $product->main_image : '', 'slug' => $product->slug]);
        }

        $status = true;
        $message = $product->title . " added in cart 2";

        return response()->json([
            'status'    => $status,
            'message'   => $message,
            'count'     => Cart::count(),
            'subtotal'  => Cart::subTotal(),
            'cartItems' => Cart::content()
        ]);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->input('rowId');
        $qty = $request->input('qty');

        // Retrieve the cart item
        $cartItem = Cart::get($rowId);

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found in cart'
            ]);
        }

        // Update the cart with the validated quantity
        Cart::update($rowId, $qty);

        $message = 'Cart updated successfully';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }


    public function deleteItem(Request $request)
    {
        $rowId = $request->rowId;
        $isMini = $request->isMini;
        $itemInfo = Cart::get($rowId);

        if ($itemInfo == null) {
            $message = "Item not found";
            session()->flash('false', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        } else {
            $message = 'Item deleted successfully';
            Cart::remove($rowId);
            session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        }
    }

    public function checkout()
    {
        if (Cart::count() == 0) {
            return redirect()->route('web.view.cart');
        } else {

            $ukCities = config('constants.ukCities');
            $ukPostalcode = config('constants.ukPostalcode');
            $ukAddress = Config('constants.ukAddress');

            return view('web.pages.checkout', compact('ukCities','ukPostalcode', 'ukAddress'));
        }
    }

    public function destroy()
    {
        Cart::destroy();
    }

    public function checkout_id($order_id)
    {

        $decoded_order_id = base64_decode($order_id);

        // Fetch the order details with related models
        $order = Order::with('orderDetails', 'shippingDetail')->find($decoded_order_id);

        if (!$order) {
            return redirect()->back()->withErrors(['error' => 'Order not found']);
        }

        if ($order->payment_status == 'Paid') { // Replace 'desired_status' with the actual status you want to check for
            return redirect()->back()->withErrors(['error' => 'Order status is not valid']);
        }

        $ukCities = config('constants.ukCities');
        $ukPostalcode = config('constants.ukPostalcode');

        return view('web.pages.checkoutid', compact('ukCities', 'ukPostalcode', 'order'));
    }


    public function reorder(Request $request)
    {
        $orderId = $request->input('order_id');

        // Fetch the order and its details
        $order = Order::with('orderdetails')->find($orderId);

        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found']);
        }

        // Prepare to add items to cart
        foreach ($order->orderdetails as $detail) {
            // Find the product using the product ID from the order details
            $product = Product::find($detail->product_id); // Assuming `product_id` is the column in `orderdetails`

            if (!$product) {
                continue; // Skip if product not found
            }

            $variant = null;
            if ($detail->variant_id) {
                // Find the variant if there is one
                $variant = ProductVariant::find($detail->variant_id);
            }

            // Prepare data for cart
            $cartData = [
                'productImage' => $product->main_image ?? '',
                'slug' => $product->slug,
                'order_type' => 'pom/reorder' // Add the order type
            ];

            if ($variant) {
                // Prepare variant information
                $vart_type = explode(';', $variant->title);
                $vart_value = explode(';', $variant->value);
                $var_info = '<br>';
                foreach ($vart_type as $key => $type) {
                    $var_info .= "<b>$type:</b> {$vart_value[$key]}";
                    if ($key < count($vart_type) - 1) {
                        $var_info .= ', ';
                    }
                }
                $variant['new_var_info'] = $var_info;

                // Add to cart with variant
                Cart::add(
                    $product->id . '_' . $variant->id,
                    $product->title,
                    $detail->product_qty,
                    $variant->price,
                    array_merge($cartData, ['variant_info' => $variant])
                );
            } else {
                // Add to cart without variant
                Cart::add(
                    $product->id,
                    $product->title,
                    $detail->product_qty,
                    $product->price,
                    $cartData
                );
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Order items added to cart',
            'redirect' => route('web.view.cart')
        ]);
    }

}
