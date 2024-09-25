<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    protected $status;
    protected $user;
    private $menu_categories;

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
    public function admin_dashboard_detail()
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

}
