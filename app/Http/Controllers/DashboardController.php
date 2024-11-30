<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\StoreCompanyDetailsRequest;
use App\Http\Requests\Dashboard\StoreQueryRequest;
use App\Models\ClientQuery;
use App\Models\CompanyDetail;
use App\Models\Order;
use App\Models\UserAddress;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Exceptions\InvalidFormatException;

class DashboardController extends Controller
{
    protected $status;
    protected $user;
    public function index()
    {
        $user = auth()->user();

        if ($user) {
            $this->authorize('dashboard');

            // Store user details in session
            session(['user_details' => $user]);

            $data['user'] = $user;
            $data['role'] = $user->getRoleNames()->first(); // Get the first role name assigned to the user

            // User role handling with Spatie
            if ($user->hasRole('super_admin')) {
                return view('admin.pages.dashboard', $data);
            } elseif ($user->hasRole('dispensary')) {
                return view('admin.pages.dispensary_dashboard', $data);
            } elseif ($user->hasRole('pharmacy')) {
                return view('admin.pages.pharmacy_dashboard', $data);
            } elseif ($user->hasRole('doctor')) {
                return view('admin.pages.doctor_dashboard', $data);
            } elseif ($user->hasRole('user')) {
                return view('admin.pages.profile_setting', $data);
            }

            // Default case if no roles match (optional)
            return redirect('/sign-in');
        } else {
            return redirect('/sign-in');
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
        $user = auth()->user();

        // Initialize the variable for storing the role
        $orderFor = '';

        // Check user role using Spatie and set $orderFor accordingly
        if ($user->hasRole('dispensary')) {
            $orderFor = 'dispensary';
        } elseif ($user->hasRole('Doctor')) {
            $orderFor = 'Doctor';
        } elseif ($user->hasRole('pharmacy')) {
            $orderFor = 'dispensary';
        } else {
            // Handle case for Super Admin or User role
            return response()->json(['error' => 'Unauthorized access or no orders available for this role.'], 403);
        }

        // Retrieve order details based on the role (Despensory or Doctor)
        $totalOrders = Order::where('order_for', $orderFor)->count();
        $paidOrders = Order::where('payment_status', 'paid')->where('order_for', $orderFor)->count();
        $unpaidOrders = Order::where('payment_status', 'Unpaid')->where('order_for', $orderFor)->count();
        $shippedOrders = Order::where('status', 'Shipped')->where('order_for', $orderFor)->count();
        $receivedOrders = Order::where('status', 'Received')->where('order_for', $orderFor)->count();
        $refundOrders = Order::where('status', 'Refund')->where('order_for', $orderFor)->count();
        $notApprovedOrders = Order::where('status', 'Not_Approved')->where('order_for', $orderFor)->count();
        // $totalAmount = Order::where('order_for', $user)->sum('total_ammount');
        $totalAmount = number_format(Order::where('order_for', $orderFor)->sum('total_ammount'), 2);

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

    public function contact()
    {
        $user = auth()->user();
        $user->hasPermissionTo('store_query');

        // Store the authenticated user in $data
        $data['user'] = $user;

        if ($user->hasRole('super_admin')) {
            // Super Admin can view all queries
            $data['queries'] = ClientQuery::all()->toArray();
        } else {
            // Other users can only view their own queries
            $data['queries'] = ClientQuery::where('user_id', $user->id)->get()->toArray();
        }

        // Retrieve company contact details
        $data['contact_details'] = CompanyDetail::all()->keyBy('content_type')->toArray();

        // Render the contact view with the data
        return view('admin.pages.contact', $data);
    }
    public function faq()
    {
        return view('admin.pages.faq');
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
    public function store_query(StoreQueryRequest $request)
    {
        $user = auth()->user();
        $this->authorize('store_query');

        $query_data = [
            'user_id'    => $user->id,
            'name'       => ucwords($request->name),
            'email'      => $request->email,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'type'       => $request->type,
            'created_by' => $user->id,
        ];

        $saved = ClientQuery::create($query_data);

        // Message based on whether it's a new query or an update
        $message = "Your Query has been " . ($request->id ? "Updated" : "Sent") . " Successfully. ⚡️";

        // Check if the query was saved and return a response
        if ($saved) {
            notify()->success($message);
            return redirect()->back()->with(['msg' => $message]);
        }

        // If not saved, return an error message
        notify()->error("There was an issue submitting your query. Please try again. ⚡️");
        return redirect()->back()->withInput();
    }

    public function store_company_details(StoreCompanyDetailsRequest $request)
    {
        $user = auth()->user();
        if (!$user->can('update_company_details')) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to perform this action.']);
        }

        // Loop through all form data and update or create the company details
        $data = $request->except(['_token', 'detail_type']); // Exclude _token and detail_type from processing
        $detailType = ucwords($request->detail_type);

        foreach ($data as $key => $value) {
            $query_data = [
                'detail_type'  => $detailType,
                'content_type' => $key,
                'content'      => $value ?? null,
                'created_by'   => $user->id,
                'updated_by'   => $user->id,
            ];

            CompanyDetail::updateOrCreate(
                ['content_type' => $key],
                $query_data
            );
        }

        // Notify and redirect with success message
        $message = "Your Details have been updated successfully. ⚡️";
        notify()->success($message);
        return redirect()->back()->with(['msg' => $message]);
    }

}
