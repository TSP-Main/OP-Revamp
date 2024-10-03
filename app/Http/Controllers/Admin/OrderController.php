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
        $orders = Order::with(['user', 'orderdetails', 'orderdetails.product'])->where(['payment_status' => 'Paid', 'user_id' => $user->id, 'order_for' => 'doctor'])->latest('created_at')->get()->toArray();
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
        $orders = Order::with(['user', 'orderdetails', 'orderdetails.product'])->where(['payment_status' => 'Paid', 'email' => $user->email, 'order_for' => 'despensory'])->latest('created_at')->get()->toArray();
        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $orders_typed = $this->assign_order_types($orders);
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
        $orders = Order::with(['user', 'orderdetails', 'orderdetails.product'])->where(['payment_status' => 'Paid', 'email' => $user->email, 'order_for' => 'despensory'])->latest('created_at')->get()->toArray();
        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $orders_typed = $this->assign_order_types($orders);
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
        $emails = array_unique(Arr::pluck($orders, 'email'));
        $prev_orders = Order::select('email', DB::raw('count(*) as total_orders'))->whereIn('email', $emails)->where('payment_status', 'Paid')->groupBy('email')->get()->sortBy('email')->values()->keyBy('email')->toArray();
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
