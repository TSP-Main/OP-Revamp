<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Traits\UserStatusTrait;

class OrderController extends Controller
{
    use UserStatusTrait;

    public function prescription_orders()
    {
        $user = $this->getAuthUser();
        $user->hasPermissionTo('prescription_orders');

        $data['user'] = $user;
        $orders = Order::with(['user', 'orderdetails.product.variants']) 
        ->where(['payment_status' => 'Paid', 'user_id' => $user->id, 'order_for' => 'doctor'])
        ->latest('created_at')->get()->toArray();
        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $orders;
        }

        $data['title'] = 'Prescription Orders';
        return view('admin.pages.prescription_orders', $data);
    }

    public function online_clinic_orders()
    {
        $user = $this->getAuthUser();
        $user->hasPermissionTo('online_clinic_orders');

        $data['user'] = $user;

        // Modify the query to join the shipping_details table
        $orders = Order::with(['user', 'orderdetails', 'orderdetails.product', 'shippingDetails'])
            ->whereHas('shippingDetails', function($query) use ($user) {
                $query->where('email', $user->email); // Use email from shipping_details table
            })
            ->where(['payment_status' => 'Paid', 'order_for' => 'despensory'])
            ->latest('created_at')
            ->get()
            ->toArray();

        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders); // Use updated get_prev_orders
            $orders_typed = $this->assign_order_types($orders);

            // Filter orders by order_type 'pmd'
            $pmdOrders = array_filter($orders_typed, function ($order) {
                return $order['order_type'] === 'pmd';
            });

            $data['orders'] = $pmdOrders;
        }

        $data['title'] = 'Online Clinic Orders';
        return view('admin.pages.online_clinic_orders', $data);
    }


    public function shop_orders()
    {
        $user = $this->getAuthUser();
        $user->hasPermissionTo('shop_orders');

        $data['user'] = $user;

        // Fetch orders where email is from shipping details
        $orders = Order::with([
            'user',
            'orderdetails',
            'orderdetails.product',
            'shippingDetails'
        ])
            ->whereHas('shippingDetails', function ($query) use ($user) {
                $query->where('email', $user->email); // Filter based on email in shipping details
            })
            ->where('payment_status', 'Paid')
            ->where('order_for', 'despensory')
            ->latest('created_at')
            ->get()
            ->toArray();

        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $orders_typed = $this->assign_order_types($orders);

            // Filter orders by type
            $otcOrders = array_filter($orders_typed, function ($order) {
                return $order['order_type'] === 'one_over';
            });

            $data['orders'] = $otcOrders;
        }

        $data['title'] = 'Shop Orders';
        return view('admin.pages.shop_orders', $data);
    }


    private function get_prev_orders($orders)
    {
        // Extract unique order IDs from the orders array
        $orderIds = array_unique(Arr::pluck($orders, 'id'));

        // Join the shipping_details table to get emails
        $prev_orders = Order::select('shipping_details.email', DB::raw('count(orders.id) as total_orders'))
            ->join('shipping_details', 'shipping_details.order_id', '=', 'orders.id') // Join shipping_details
            ->whereIn('orders.id', $orderIds) // Use order IDs instead of emails
            ->where('orders.payment_status', 'Paid')
            ->groupBy('shipping_details.email')
            ->orderBy('shipping_details.email')
            ->get()
            ->keyBy('email')
            ->toArray();

        return $prev_orders;
    }


    private function assign_order_types($orders)
    {
        foreach ($orders as &$order) {
            $consultationTypes = array_column($order['orderdetails'], 'consultation_type');

            if (in_array('premd', $consultationTypes)) {
                $order['order_type'] = 'premd';
            } elseif (in_array('pmd', $consultationTypes)) {
                $order['order_type'] = 'pmd';
            } else {
                $order['order_type'] = 'one_over';
            }
        }
        return $orders;
    }
}
