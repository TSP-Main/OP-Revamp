<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Mail\OrderConfirmation;
use App\Models\ProductVariant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Http;
use App\Models\ShippingDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\PaymentDetail;
use App\Traits\MenuCategoriesTrait;
use App\Notifications\UserOrderNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    use MenuCategoriesTrait;
    public function cart()
    {
        $this->shareMenuCategories();
        $data['cartContent'] = Cart::content();
        return view('web.pages.cart', $data);
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        $variant_id = $request->variantId ?? null;
        $quantity = $request->quantity ?? 1;
        $cartItems = collect(Cart::content());
        $prod_id = $request->id;
    
        $variant = null;
        if ($variant_id) {
            $variant = ProductVariant::find($variant_id);
        }
    
        // Check if the product is high risk
        $isHighRisk = $product->high_risk == 2;
    
        // Check if there's already a high-risk product in the cart
        if ($isHighRisk && $cartItems->contains(function ($item) {
            $cartProduct = Product::find(explode('_', $item->id)[0]); // Get the product ID from the cart item ID
            return $cartProduct && $cartProduct->high_risk == 2;
        })) {
            return response()->json([
                'status' => false,
                'message' => 'You can only add one high-risk product to the cart.'
            ]);
        }
    
        // Check minimum buy quantity
        if (($product->min_buy && $quantity < $product->min_buy && $cartItems->isEmpty())) {
            return response()->json([
                'status' => false,
                'message' => 'Buy minimum ' . $product->min_buy . ' quantity'
            ]);
        }
    
        // Check maximum buy quantity
        $item = $cartItems->filter(function ($value) use ($prod_id) {
            return strpos($value->id, $prod_id) !== false;
        });
    
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
                    'message' => 'Max buy ' . $product->max_buy . ' quantity. You already added ' . $sumOfQty
                ]);
            }
        }
    
        // Add the product to the cart
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
            Cart::add($product->id . '_' . $variant->id, $product->title, $quantity, $variant->price, [
                'productImage' => (!empty($product->main_image)) ? $product->main_image : '',
                'variant_info' => $variant,
                'slug' => $product->slug,
                'high_risk' => $product->high_risk,
                'max_buy' => $product->max_buy,
                'min_buy' => $product->min_buy,

            ]);
        } else {
            Cart::add($product->id, $product->title, $quantity, $product->price,[
                'productImage' => (!empty($product->main_image)) ? $product->main_image : '',
                'slug' => $product->slug,
                'high_risk' => $product->high_risk,
                'max_buy' => $product->max_buy,
                'min_buy' => $product->min_buy,
            ]);
        }

          // Log the cart data for debugging
            // \Log::info('Product added to cart:', [
            //     'product_id' => $product->id,
            //     'product_title' => $product->title,
            //     'quantity' => $quantity,
            //     'high_risk' => $product->high_risk,
            //     'cart_content' => Cart::content()
            // ]);
        
        $status = true;
        $message = $product->title . " added to cart.";
        
       // dd(Cart::content());
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
        $this->shareMenuCategories();
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


    // public function reorder(Request $request)
    // {
    //     $orderId = $request->input('order_id');

    //     // Fetch the order and its details
    //     $order = Order::with('orderdetails')->find($orderId);

    //     if (!$order) {
    //         return response()->json(['status' => false, 'message' => 'Order not found']);
    //     }

    //     // Prepare to add items to cart
    //     foreach ($order->orderdetails as $detail) {
    //         // Find the product using the product ID from the order details
    //         $product = Product::find($detail->product_id); // Assuming `product_id` is the column in `orderdetails`

    //         if (!$product) {
    //             continue; // Skip if product not found
    //         }

    //         $variant = null;
    //         if ($detail->variant_id) {
    //             // Find the variant if there is one
    //             $variant = ProductVariant::find($detail->variant_id);
    //         }

    //         // Prepare data for cart
    //         $cartData = [
    //             'productImage' => $product->main_image ?? '',
    //             'slug' => $product->slug,
    //             'order_type' => 'pom/reorder' // Add the order type
    //         ];

    //         if ($variant) {
    //             // Prepare variant information
    //             $vart_type = explode(';', $variant->title);
    //             $vart_value = explode(';', $variant->value);
    //             $var_info = '<br>';
    //             foreach ($vart_type as $key => $type) {
    //                 $var_info .= "<b>$type:</b> {$vart_value[$key]}";
    //                 if ($key < count($vart_type) - 1) {
    //                     $var_info .= ', ';
    //                 }
    //             }
    //             $variant['new_var_info'] = $var_info;

    //             // Add to cart with variant
    //             Cart::add(
    //                 $product->id . '_' . $variant->id,
    //                 $product->title,
    //                 $detail->product_qty,
    //                 $variant->price,
    //                 array_merge($cartData, ['variant_info' => $variant])
    //             );
    //         } else {
    //             // Add to cart without variant
    //             Cart::add(
    //                 $product->id,
    //                 $product->title,
    //                 $detail->product_qty,
    //                 $product->price,
    //                 $cartData
    //             );
    //         }
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Order items added to cart',
    //         'redirect' => route('web.view.cart')
    //     ]);
    // }

    

    public function reorder(Request $request)
    {
        // Validate input
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'quantities' => 'array',
        ]);
        
        $orderId = $request->input('order_id');
        $quantities = $request->input('quantities', []);
        
        // Fetch the existing order and its details
        $existingOrder = Order::with(['orderdetails', 'shippingdetails'])->find($orderId);
        
        if (!$existingOrder) {
            return response()->json(['status' => false, 'message' => 'Order not found']);
        }
        
        try {
            // Create a new order record
            $newOrder = Order::create([
                'user_id' => $existingOrder->user_id,
                'note' => $existingOrder->note,
                'payment_status' => 'Unpaid',
                'total_ammount' => 0, // Initialize as 0, will calculate later
                'status' => 'Received',
                'order_for' => 'doctor',
            ]);
    
            $totalAmount = 0; // Initialize total amount for calculation
    
            // Clone order details into the new order with updated quantities
            foreach ($existingOrder->orderdetails as $detail) {
                if (isset($quantities[$detail->id]) && $quantities[$detail->id]['qty'] > 0) {
                    $variantId = $quantities[$detail->id]['variant_id'] ?? null; // Get selected variant ID
                    
                    // Fetch variant price if it exists
                    $variantPrice = null;
                    if ($variantId) {
                        $variant = ProductVariant::find($variantId);
                        $variantPrice = $variant ? $variant->price : null;
                    }
    
                    // Calculate total amount using the variant price or the product's price
                    $priceToUse = $variantPrice ?? $detail->product->price;
                    $totalAmount += $priceToUse * $quantities[$detail->id]['qty'];
    
                    OrderDetail::create([
                        'order_id' => $newOrder->id,
                        'product_id' => $detail->product_id,
                        'variant_id' => $variantId, // Store the selected variant ID
                        'weight' => $detail->weight,
                        'product_qty' => $quantities[$detail->id]['qty'], // Use the selected quantity
                        'generic_consultation' => $detail->generic_consultation ?? null,
                        'product_consultation' => $detail->product_consultation ?? null,
                        'consultation_type' => 'premd/Reorder',
                        'status' => '1',
                        'created_by' => auth()->id(),
                    ]);
                }
            }
            
            // Update the total amount of the new order
            $newOrder->total_ammount = $totalAmount;
            $newOrder->save();
    
            if ($existingOrder->shippingdetails) {
                $shippingDetail = $existingOrder->shippingdetails; // Get the single shipping detail
                $shippingData = $shippingDetail->toArray();
                $shippingData['order_id'] = $newOrder->id; 
                ShippingDetail::create($shippingData);
            }
    
            // Prepare for payment processing
            session()->put('order_id', $newOrder->id);
            $payable_amount = $newOrder->total_ammount * 100; // Convert to cents if needed
            $productDescription = 'Reorder from Pharmacy 4U';
            $full_name = $existingOrder->email; // Assuming email is used for full name
    
            // Obtain Access Token
            $accessToken = $this->getAccessToken();
    
            // Prepare POST fields for creating a payment order
            $postFields = [
                'amount' => $payable_amount,
                'customerTrns' => $productDescription,
                'customer' => [
                    'email' => $existingOrder->email,
                    'fullName' => $full_name,
                    'phone' => $request->phone,
                    'countryCode' => 'GB',
                    'requestLang' => 'en-GB',
                ],
                'paymentTimeout' => 1800,
                'preauth' => false,
                'allowRecurring' => false,
                'maxInstallments' => 0,
                'paymentNotification' => true,
                'disableExactAmount' => false,
                'disableCash' => false,
                'disableWallet' => false,
                'sourceCode' => '1503',
                'merchantTrns' => "Reorder from Pharmacy 4U",
            ];
    
            $response = $this->sendHttpRequest('https://api.vivapayments.com/checkout/v2/orders', $postFields, $accessToken);
            $responseData = json_decode($response, true);
    
            if (isset($responseData['orderCode'])) {
                $orderCode = $responseData['orderCode'];
                $temp_code = random_int(00000, 99999);
                $payment_details = [
                    'order_id' => $newOrder->id,
                    'orderCode' => ($this->ENV == 'Live') ? $orderCode : $temp_code,
                    'amount' => $newOrder->total_ammount,
                ];
    
                $payment_init = PaymentDetail::create($payment_details);
                if ($payment_init) {
                    $redirectUrl = ($this->ENV == 'Live') 
                        ? "https://www.vivapayments.com/web/checkout?ref={$orderCode}" 
                        : url("/Completed-order?t=$temp_code&s=$temp_code&lang=en-GB&eventId=0&eci=1");
    
                    return response()->json(['status' => true, 'message' => 'Order items cloned successfully.', 'redirect' => $redirectUrl]);
                }
            }
    
            return response()->json(['status' => false, 'message' => 'Failed to initiate payment.']);
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Reorder Error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
    
    private function getAccessToken()
    {
        try {
            // Viva Wallet API credentials
            $username = 'dkwrul3i0r4pwsgkko3nr8c4vs0h5yn5tunio398ik403.apps.vivapayments.com'; // Replace with your actual client ID
            $password = 'BuLY8U1pEsXNPBgaqz98y54irE7OpL'; // Replace with your actual secret key
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
                \Log::error('Error response: ' . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            // Log any exceptions that occurred during the request
            \Log::error('Exception: ' . $e->getMessage());
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

    public function completedOrder(Request $request)
    {
        $transetion_id = $request->query('t');
        $orderCode = $request->query('s');
    
        $payment_detail = PaymentDetail::where('orderCode', $orderCode)->first();
    
        if (!$payment_detail) {
            return response()->json(['status' => false, 'message' => 'No payment details found.'], 404);
        }
    
        if ($this->ENV == 'Live') {
            $accessToken = $this->getAccessToken();
            $url = "https://api.vivapayments.com/checkout/v2/transactions/{$transetion_id}";
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->get($url);
    
            if ($response->failed()) {
                return response()->json(['status' => false, 'message' => 'Failed to retrieve transaction details.'], 500);
            }
    
            $responseData = json_decode($response->body(), true);
            
            // Validate response data
            if (!isset($responseData['fullName'], $responseData['email'])) {
                return response()->json(['status' => false, 'message' => 'Invalid response from payment gateway.'], 400);
            }
    
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
    
        PaymentDetail::where('id', $payment_detail->id)->update($update_payment);
    
        $order = Order::with('orderdetails', 'orderdetails.product')
            ->where('id', $payment_detail->order_id)
            ->latest('created_at')
            ->first();
    
        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found.'], 404);
        }
    
        $user = auth()->user();
        $order->update(['payment_status' => 'Paid']);
        
        // Notify relevant users
        $rolesToCheck = ['super_admin'];
        if ($order->order_for === 'doctor') {
            $rolesToCheck[] = 'doctor';
        } else {
            $rolesToCheck[] = 'dispensary';
        }
        
        $users = User::role($rolesToCheck)->where('status', 1)->get();
        Notification::send($users, new UserOrderNotification($order));
        Mail::to($order->shippingDetails->email)->send(new OrderConfirmation($order));
    
        // Logout and redirect
        Session::flush();
        if ($user) {
            Auth::logout();
            Auth::login($user);
        }
    
        $name = $order->shippingDetails->firstName;
        $redirectUrl = route('thankYou', ['n' => $name]);
    
        return response()->json(['status' => true, 'redirect' => $redirectUrl]);
    }

    
    
}
