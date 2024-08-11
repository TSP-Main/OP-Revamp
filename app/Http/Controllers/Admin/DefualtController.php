<?php

namespace App\Http\Controllers\Admin;

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
use App\Mail\OTPMail;

// models ...
use App\Models\User;
use App\Models\ClientQuery;
use App\Models\CompanyDetail;
use App\Models\Category;
use App\Models\Question;
use App\Models\AssignQuestion;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductAttribute;

use Illuminate\Support\Facades\URL;


class DefualtController extends Controller
{
    protected $status;
    protected $user;
    private $menu_categories;




    public function __construct()
    {
        $this->user = auth()->user();
        $this->status = config('constants.USER_STATUS');

        $this->menu_categories = Category::where('status', 'Active')
            ->with([
                'subcategory' => function ($query) {
                    $query->where('status', 'Active')
                        ->with([
                            'childCategories' => function ($query) {
                                $query->where('status', 'Active');
                            }
                        ]);
                }
            ])
            ->where('publish', 'Publish')
            ->latest('id')
            ->get()
            ->toArray();

        view()->share('menu_categories', $this->menu_categories);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user) {
            $page_name = 'dashboard';
            if (!view_permission($page_name)) {
                return redirect()->back();
            }
            session(['user_details' => $user]);
            $data['user'] = $user;
            $data['role'] = user_role_no($user->role);
            // User roles: 1 for Super Admin, 2 for Despensory, 3 for Doctor, 4 User
            if (isset($user->role) && $user->role == user_roles('1')) {
                return view('admin.pages.dashboard', $data);
            } else if (isset($user->role) && $user->role == user_roles('2')) {
                return view('admin.pages.despensory_dashboard', $data);
            } else if (isset($user->role) && $user->role == user_roles('3')) {
                return view('admin.pages.doctor_dashboard', $data);
            } else if (isset($user->role) && $user->role == user_roles('4')) {
                // return redirect('/');
                return view('admin.pages.profile_setting', $data);
            }
        } else {
            return redirect('/login');
        }
    }


    public function admin_dashboard_detail(Request $request)
    {


        $totalOrders = Order::count();
        $notApprovedOrders = Order::where('status', 'Not_Approved')->count();
        $paidOrders = Order::where('payment_status', 'paid')->count();
        $UnpaidOrders = Order::where('payment_status', 'Unpaid')->count();
        $totalSales = Order::where('status', 'paid')->sum('total_ammount');
        $totalSales = Order::where('payment_status', 'paid')->sum('total_ammount');
        $doctorOrders = Order::where('order_for', 'doctor')->count();
        $despensoryOrders = Order::where('order_for', 'despensory')->count();


        // Return the total orders as a JSON response
        return response()->json([
            'totalOrders' => $totalOrders,
            'notApprovedOrders' => $notApprovedOrders,
            'paidOrders' => $paidOrders,
            'UnpaidOrders' => $UnpaidOrders,
            'totalSales' => $totalSales,
            'doctorOrders' => $doctorOrders,
            'despensoryOrders' => $despensoryOrders
        ]);

    }

    public function dashboard_details(Request $request)
    {
        // Retrieve the role value from the request
        // User roles: 1 for Super Admin, 2 for Despensory, 3 for Doctor, 4 User
        $role = $request->input('role');

        // Initialize $user variable
        $user = '';

        // Set $user based on role
        if ($role == '2') {
            $user = 'Despensory';
        } elseif ($role == '3') {
            $user = 'Doctor';
        }

        // Retrieve order details based on $user
        $totalOrders = Order::where('order_for', $user)->count();
        $paidOrders = Order::where('payment_status', 'paid')->where('order_for', $user)->count();
        $unpaidOrders = Order::where('payment_status', 'Unpaid')->where('order_for', $user)->count();
        $shippedOrders = Order::where('status', 'Shipped')->where('order_for', $user)->count();
        $receivedOrders = Order::where('status', 'Received')->where('order_for', $user)->count();
        $refundOrders = Order::where('status', 'Refund')->where('order_for', $user)->count();
        $notApprovedOrders = Order::where('status', 'Not_Approved')->where('order_for', $user)->count();
        // $totalAmount = Order::where('order_for', $user)->sum('total_ammount');
        $totalAmount = number_format(Order::where('order_for', $user)->sum('total_ammount'), 2);

        // dd($totalAmount, $user, $totalOrders, $paidOrders, $unpaidOrders, $shippedOrders, $receivedOrders, $refundOrders, $notApprovedOrders);

        // Return JSON response with order details
        return response()->json([
            'totalOrders' => $totalOrders,
            'paidOrders' => $paidOrders,
            'unpaidOrders' => $unpaidOrders,
            'shippedOrders' => $shippedOrders,
            'receivedOrders' => $receivedOrders,
            'refundOrders' => $refundOrders,
            'notApprovedOrders' => $notApprovedOrders,
            'totalAmount' => $totalAmount
        ]);
    }

    public function profile_setting(Request $request)
    {
        $user = auth()->user();
        $page_name = 'setting';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
        if ($request->all()) {
            $rules = [
                'name' => 'required',
                'phone' => 'required|digits:11',
                'address' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id),
                ],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['user'] = auth()->user();

            if ($request->file('user_pic')) {
                $image = $request->file('user_pic');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('user_images', $imageName, 'public');
                $ImagePath = 'user_images/' . $imageName;
            }
            $updateData = [
                'name' => ucwords($request->name),
                'email' => $request->email,
                'phone' => $request->phone,
                'user_pic' => $ImagePath ?? $user->user_pic,
                'address' => $request->address,
                'short_bio' => $request->short_bio,
                'status' => $this->status['Active'],
                'created_by' => $user->id,
            ];
            $saved = User::updateOrCreate(
                ['id' => $user->id ?? NULL],
                $updateData
            );
            $message = "profile" . ($user->id ? "Updated" : "Saved") . " Successfully";
            if ($saved) {
                return redirect()->route('admin.profileSetting')->with(['msg' => $message]);
            }
        }

        $data['user'] = $user;
        return view('admin.pages.profile_setting', $data);
    }

    public function password_change(Request $request)
    {
        $user = auth()->user();
        $page_name = 'setting';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
        if ($request->all()) {
            $rules = [
                'current_password' => 'required',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Check if the current password matches the one in the database
            if (Hash::check($request->current_password, $user->password)) {
                $hashedPassword = Hash::make($request->password);
                $updateData = [
                    'password' => $hashedPassword,
                    'created_by' => $user->id,
                ];
                $saved = User::updateOrCreate(
                    ['id' => $user->id ?? NULL],
                    $updateData
                );
                $message = "Password " . ($user->id ? "Updated" : "Saved") . " Successfully";
                if ($saved) {
                    return redirect()->route('admin.profileSetting')->with(['msg' => $message]);
                }
            } else {
                return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
            }
        }

        $data['user'] = $user;
        return view('admin.pages.profile_setting', $data);
    }

    public function faq()
    {
        return view('admin.pages.faq');
    }

    public function contact()
    {
        $user = auth()->user();
        $page_name = 'store_query';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
        $data['user'] = auth()->user();
        if($user->role == user_roles(1)){
            $data['queries'] = ClientQuery::get()->toArray();
        }else{
            $data['queries'] = ClientQuery::where('user_id', $user->id)->get()->toArray();
        }
        $data['contact_details'] = CompanyDetail::get()->keyBy('content_type')->toArray();
        return view('admin.pages.contact', $data);
    }

    public function login(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            if ($request->all()) {
                $validator = Validator::make($request->all(), [
                    'email' => [
                        'required',
                        'email',
                    ],
                    'password' => [
                        'required',
                        'min:8'
                    ]
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput()->with(['status' => 'error', 'message' => $validator->errors()]);
                }

                $credentials = $request->only('email', 'password');
                $user = User::where('email', $credentials['email'])->first();

                if ($user) {
                    if (in_array($user->status, auth_users())) {
                        if (Auth::attempt($credentials)) {
                            $token = $user->createToken('MyApp')->plainTextToken;
                            if (isset($user->role) && $user->role == user_roles('1')) {
                                return redirect('/admin');
                            } else if (isset($user->role) && $user->role == user_roles('2')) {
                                return redirect('/admin');
                            } else if (isset($user->role) && $user->role == user_roles('3')) {
                                return redirect('/admin');
                            } else if (isset($user->role) && $user->role == user_roles('4')) {
                                $intendedUrl = session('intended_url');
                                session()->forget('intended_url');
                                if ($intendedUrl) {
                                    return redirect()->route('web.consultationForm');
                                } else {
                                    return redirect('/admin');
                                }
                            }
                            // return redirect()->back()->with(['status' => 'success', 'message' => 'User successfully logged in', 'token' => $token]);
                        } else {
                            return redirect()->back()->with(['status' => 'invalid', 'message' => 'Invalid Credentails', 'email' => $credentials['email']]);
                        }
                    } else if ($user->status == 4) {
                        return redirect()->back()->with(['status' => 'Unverfied', 'message' => 'User is unverified, Please Check Your Email', 'email' => $credentials['email']]);
                    } else {
                        return redirect()->back()->with(['status' => 'Deactive', 'message' => 'You are Unauthorized to Login', 'email' => $credentials['email']]);
                    }
                } else {
                    return redirect()->back()->with(['status' => 'noexitance', 'message' => 'User does not exist', 'email' => $credentials['email']], 401);
                }
            } else {
                return view('web.pages.login');
            }
        } else {
            if (isset($user->role) && $user->role == user_roles('1')) {
                return redirect('/admin');
            } else if (isset($user->role) && $user->role == user_roles('2')) {
                return redirect('/admin');
            } else if (isset($user->role) && $user->role == user_roles('3')) {
                return redirect('/admin');
            } else if (isset($user->role) && $user->role == user_roles('4')) {
                return redirect('/');
            }
        }
        return view('web.pages.login');
    }

    public function logout(REQUEST $request)
    {
        $user = auth()->user();

        session()->flush();
        Auth::logout();

        if (isset($user->role) && $user->role == user_roles('1')) {
            return redirect('/login');
        } else if (isset($user->role) && $user->role == user_roles('2')) {
            return redirect('/login');
        } else if (isset($user->role) && $user->role == user_roles('3')) {
            return redirect('/login');
        } else if (isset($user->role) && $user->role == user_roles('4')) {
            return redirect('/');
        }
    }

    public function registration_form(Request $request)
    {
        $data['user'] = auth()->user() ?? [];
        if (auth()->user()) {
            return redirect('/admin');
        } else {
            return view('web.pages.registration_form', $data);
        }
    }

    public function user_register(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'phone' => 'required|digits:11',
                    'address' => 'required',
                    'gender' => 'required',
                    'id_document' => 'required',
                    'day' => 'required',
                    'month' => 'required',
                    'year' => 'required',
                    'zip_code' => 'required',
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('users')->ignore($request->id),
                    ],
                    'password' => [
                        'required',
                        'min:8'
                    ]
                ],
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['user'] = auth()->user();
            $dob = $request->day . '-' . $request->month . '-' . $request->year;

            if ($request->file('id_document')) {
                $doc = $request->file('id_document');
                $docName = uniqid() . time() . '_' . $doc->getClientOriginalName();
                $doc->storeAs('user_docs', $docName, 'public');
                $docPath = 'user_docs/' . $docName;
            }

            $saved = User::updateOrCreate(
                ['id' => $request->id ?? NULL],
                [
                    'name' => ucwords($request->name),
                    'email' => $request->email,
                    'dob' => $dob,
                    'role' => $request->role ?? 'User',
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                    'gender' => $request->gender,
                    'id_document' => $docPath ?? Null,
                    'zip_code' => $request->zip_code,
                    'city' => $request->city ?? '',
                    'state' => $request->state ?? '',
                    'password' => Hash::make($request->password),
                    'status' => $this->status['Active'],
                    'created_by' => 1,
                ]
            );

            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = auth()->user();
                $token = $user->createToken('MyApp')->plainTextToken;
            }
            $message = "User" . ($request->id ? "Registraion" : "Registraion") . " Successfully";
            if ($saved) {
                $intendedUrl = session('intended_url');
                session()->forget('intended_url');
                if ($intendedUrl) {
                    return redirect()->route('web.consultationForm');
                } else {
                    return redirect('/admin');
                }
            }
        } else {
            return redirect()->back();
        }
    }

    public function forgot_password(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return view('web.pages.forgot_password');
        } else {
            return redirect()->back();
        }
    }

    public function change_password(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return view('web.pages.change_password');
        } else {
            return redirect()->back();
        }
    }

    public function send_otp(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $otp = mt_rand(100000, 999999);
                $user->otp = $otp;
                $user->save();
                Mail::to($request->email)->send(new OTPMail($otp));
                return redirect()->route('changePassword')->with(['status' => 'success', 'message' => "Please check you'r mail for OTP", 'email' => $request->email]);
            } else {
                return redirect()->back()->withInput()->withErrors(['email' => 'The provided email is incorrect.']);
            }
        } else {
            return redirect()->back();
        }
    }

    public function verify_otp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8',
        ]);

        $user = auth()->user();
        if (!$user) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if ($user->otp == trim($request->otp)) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                    return redirect()->route('login')->with(['status' => 'success', 'message' => "Password updated successfully."]);
                } else {
                    return redirect()->back()->withInput()->withErrors(['otp' => 'The provided OTP is incorrect.']);
                }
            } else {
                return redirect()->back()->withInput()->withErrors(['email' => 'The provided email is incorrect.']);
            }
        } else {
            return redirect()->back();
        }
    }

    public function read_notifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function get_unread_notifications()
    {
        $unreadNotifications = Auth::user()->unreadNotifications;
        if ($unreadNotifications) {
            // notify()->success('New order received. ⚡️');
        }
        return response()->json($unreadNotifications);
    }

    public function store_query(Request $request)
    {
        $user = auth()->user();
        $page_name = 'store_query';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
        if ($request->all()) {
            $rules = [
                'name'      => 'required',
                'subject'   => 'required',
                'message'   => 'required',
                'type'   => 'required',
                'email'     => [
                    'required',
                    'email',
                ],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                notify()->error("Fill the Form correctly. ⚡️");
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['user'] = auth()->user();
            $query_data = [
                'user_id'    => $user->id,
                'name'       => ucwords($request->name),
                'email'      => $request->email,
                'subject'    => $request->subject,
                'message'    => $request->message,
                'type'       => $request->type,
                'created_by' => $user->id,
            ];
            $saved = ClientQuery::create(
                $query_data
            );
            $message = "Your Query " . ($request->id ? "Updated" : "Sent") . " Successfully. ⚡️";
            if ($saved) {
                notify()->success($message);
                return redirect()->back()->with(['msg' => $message]);
            }
        } else {
            notify()->error("Fill the Form correctly. ⚡️");
            return redirect()->back();
        }
    }

    public function store_company_details(Request $request)
    {
        $user = auth()->user();
        $page_name = 'company_details';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
        if ($request->all()) {
            $data['user'] = auth()->user();
            $data = $request->all();
            foreach ($data as $key => $value) {
                if ($key !== '_token' && $key !== 'detail_type') {
                    $query_data = [
                        'detail_type'=> ucwords($request->detail_type),
                        'content_type' => $key,
                        'content'    => $value ?? null,
                        'created_by' => $user->id,
                        'updated_by' => $user->id,
                    ];
                    $saved = CompanyDetail::updateOrCreate(
                        ['content_type' => $key ?? NULL],
                        $query_data
                    );
                }
            }

            if ($saved) {
                $message = "Your Details are Updated Successfully. ⚡️";
                notify()->success($message);
                return redirect()->back()->with(['msg' => $message]);
            }
        } else {
            notify()->error("Fill the Form correctly. ⚡️");
            return redirect()->back();
        }
    }
}
