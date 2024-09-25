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
use Illuminate\Support\Facades\DB;
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
            if (!$user->can('dashboard')) {
                return redirect()->back()->with('error', 'You do not have permission to view this page.');
            }

            // Store user details in session
            session(['user_details' => $user]);

            $data['user'] = $user;
            $data['role'] = $user->getRoleNames()->first(); // Get the first role name assigned to the user

            // User role handling with Spatie
            if ($user->hasRole('super_admin')) {
                return view('admin.pages.dashboard', $data);
            } elseif ($user->hasRole('dispensary')) {
                return view('admin.pages.dispensary_dashboard', $data);
            } elseif ($user->hasRole('doctor')) {
                return view('admin.pages.doctor_dashboard', $data);
            } elseif ($user->hasRole('user')) {
                return view('admin.pages.profile_setting', $data);
            }

            // Default case if no roles match (optional)
            return redirect('/login');
        } else {
            return redirect('/login');
        }
    }


    public function admin_dashboard_detail(Request $request)
    {

        // Get current year, month, week, and day using Carbon
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $currentWeek = Carbon::now()->week;
        $currentDay = Carbon::now()->day;
        $totalOrdersThisYear = Order::last90Days()->count();
        $totalOrdersThisMonth = Order::monthly()->count();
        $totalOrdersThisWeek= Order::weekly()->count();
        $totalOrdersThisDay = Order::daily()->count();

        $notApprovedOrders = Order::where('status', 'Not_Approved')->count();
        $paidOrders = Order::where('payment_status', 'paid')->count();
        $UnpaidOrders = Order::where('payment_status', 'Unpaid')->count();
        $totalSales = Order::where('status', 'paid')->sum('total_ammount');
        $totalSales = Order::where('payment_status', 'paid')->sum('total_ammount');
        $doctorOrders = Order::where('order_for', 'doctor')->count();

        $despensoryOrdersThisYear = Order::last90Days('despensory')->count();
        $despensoryOrdersThisMonth = Order::monthly('despensory')->count();
        $despensoryOrdersThisWeek = Order::weekly('despensory')->count();
        $despensoryOrdersThisDay = Order::daily('despensory')->count();

        $doctorOrdersThisYear = Order::last90Days('doctor')->count();
        $doctorOrdersThisMonth = Order::monthly('doctor') ->count();
        $doctorOrdersThisWeek = Order::weekly('doctor') ->count();
        $doctorOrdersThisDay = Order:: daily('doctor') ->count();

        $paidOrdersThisYear = Order::last90Days(null,'paid')->count();
        $paidOrdersThisMonth = Order::monthly(null,'paid') ->count();
        $paidOrdersThisWeek = Order::weekly(null,'paid') ->count();
        $paidOrdersThisDay = Order:: daily(null,'paid') ->count();

        $UnpaidOrdersThisYear = Order::last90Days(null,'Unpaid')->count();
        $UnpaidOrdersThisMonth = Order::monthly(null,'Unpaid') ->count();
        $UnpaidOrdersThisWeek = Order::weekly(null,'Unpaid') ->count();
        $UnpaidOrdersThisDay = Order:: daily(null,'Unpaid') ->count();

        $pendingOrdersThisYear = Order::where('status', 'Not_Approved')->last90Days()->count();
        $pendingOrdersThisMonth = Order::where('status', 'Not_Approved')->monthly() ->count();
        $pendingOrdersThisWeek = Order::where('status', 'Not_Approved')->weekly() ->count();
        $pendingOrdersThisDay = Order:: where('status', 'Not_Approved')->daily() ->count();

        $salesThisYear = Order::last90Days(null,'paid')->sum('total_ammount');
        $salesThisMonth = Order::monthly(null,'paid')->sum('total_ammount');
        $salesThisWeek = Order::weekly(null,'paid')->sum('total_ammount');
        $salesThisDay = Order::daily(null,'paid')->sum('total_ammount');

        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

            // Query to get total sales for each day in the last week
            $grapData = Order::query()->selectRaw('DATE(created_at) as date, SUM(total_ammount) as total_sales')
                ->where('payment_status', 'paid')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date', 'asc');
            $weeklyGraphData = (clone $grapData)->weekly()->get();
            $monthlyGraphData = (clone $grapData)->monthly()->get();
            $yearlyGraphData = (clone $grapData)->yearly()->get();
            //   dd($salesData);
            return response()->json([...get_defined_vars()]);

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
