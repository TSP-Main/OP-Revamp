<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StoreHumanFormRequest;
use App\Mail\OrderConfirmation;
use App\Models\HumanRequestForm;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ShipingDetail;
use App\Models\ShippingDetail;
use App\Models\User;
use App\Notifications\UserOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use App\Traits\MenuCategoriesTrait;

class PaymentController extends Controller
{
    use MenuCategoriesTrait;
    public function payment(Request $request)
    {
        $this->shareMenuCategories();
        $user = auth()->user() ?? [];
        $data = $request->all();
        $order_ids = $request->input('order_id.order_id', []);

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
//                        'variant_details' => $var_info ?? Null,
//                        'weight' => Product::find($pro_id)->weight,
                        'order_id' => $order->id,
//                        'product_price' => $request->order_details['product_price'][$index],
//                        'product_name' => $request->order_details['product_name'][$index],
                        'product_qty' => $request->order_details['product_qty'][$index],
                        'generic_consultation' => $generic_consultation ?? NULL,
                        'product_consultation' => $product_consultation ?? NULL,
                        'consultation_type' => $consultaion_type ?? NULL,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $index++;
                }

                // Update or create OrderDetail records
                foreach ($order_details as $detail) {
                    $inserted =  OrderDetail::updateOrCreate(
                        ['order_id' => $detail['order_id']],
                        $detail
                    );
                }

                Order::where(['id' => $order->id])->latest('created_at')->first()
                    ->update(['order_for' => $order_for]);


                // $inserted =  OrderDetail::insert($order_details);
                if ($inserted) {
                    dd($request);
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
                        $shiping =  ShippingDetail::updateOrCreate(
                            ['order_id' => $detail['order_id']],
                            $detail
                        );
                    }
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

            $order =  Order::create([
                'user_id'        => $user->id ?? 'guest',
                'email'          => $request->email,
                'note'           => $request->note,
//                'shiping_cost'   => $request->shiping_cost,
//                'coupon_code'    => $request->coupon_code ?? Null,
//                'coupon_value'   => $request->coupon_value ?? Null,
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
//                        'variant_details' => $var_info ?? Null,
//                        'weight' => Product::find($pro_id)->weight,
                        'order_id' => $order->id,
//                        'product_price' => $request->order_details['product_price'][$index],
//                        'product_name' => $request->order_details['product_name'][$index],
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
                    $shiping =  ShippingDetail::create($shipping_details);
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
    public function completedOrder(Request $request)
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
                $name = $order->shippingDetails->firstName;
//                $order_for = [$user->hasRole('super_admin'), ($order->order_for == 'doctor') ? $user->hasRole('doctor') : $user->hasRole('dispensary')];
//                $users = User::where('status', 1)->WhereIn('role', $order_for)->get();
                $rolesToCheck = ['super_admin'];
                if ($order->order_for == 'doctor') {
                    $rolesToCheck[] = 'doctor';
                } else {
                    $rolesToCheck[] = 'dispensary';
                }
                // Get users with these roles using Spatie's role handling
                $users = User::role($rolesToCheck)->where('status', 1)->get();
                Notification::send($users, new UserOrderNotification($order));
                Mail::to($order->shippingDetails->email)->send(new OrderConfirmation($order));
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
                return $response->json('Order could not developer');
            }
        } else {
            dd('No Payment details found.');
        }
    }

    public function unsuccessfulOrder(Request $request)
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
                return $response->json('Order could not found.');
            }
        } else {
            dd('No Payment details found.');
        }
    }

    public function error404()
    {
        $this->shareMenuCategories();
        return view('web.pages.404');
    }
    public function thankYou(Request $request)
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

    public function transectionFail(Request $request)
    {
        $data['user'] = auth()->user() ?? [];
        $name = $request->query('n');
        $data['name'] = $name ?? 'Guest';
        return view('web.pages.unsuccessful_order', $data);
    }

    public function storeHumanForm(StoreHumanFormRequest $request)
    {
        $user = auth()->user();
        $data = $request->all();
        $data['user_id'] = $user->id ?? null;

        // Handle file upload if a file is provided
        if ($request->hasFile('file')) {
            $HumanRequestFormFile = $request->file('file');
            $HumanRequestFormFileName = time() . '_' . uniqid('', true) . '.' . $HumanRequestFormFile->getClientOriginalExtension();
            $HumanRequestFormFile->storeAs('human_request_file/', $HumanRequestFormFileName, 'public');
            $data['file'] = 'human_request_file/' . $HumanRequestFormFileName;
        }

        // Create or update the HumanRequestForm record
        $question = HumanRequestForm::updateOrCreate(
            ['id' => $request->id ?? null],
            $data
        );

        // Return success message
        if ($question->id) {
            $message = "Query is submitted successfully";
            return redirect()->back()->with(['msg' => $message]);
        }
    }

    public function successfullyRefunded(Request $request)
    {
        return 'amount is refunded';
    }
}
