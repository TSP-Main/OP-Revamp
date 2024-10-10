<?php

namespace App\Http\Controllers\Admin\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendGpaLetter;
use Illuminate\Support\Facades\Auth;
use PDF;

class PdfGeneratorController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {

        $data = $request->all();
        $data['order'] = json_decode($data['content'], true);
        $order = Order::findOrFail($data['order']['id']);
        $order->print = 'Printed';
        $update = $order->save();
        $file_name = $data['order']['id'] . '_order_details_' . $data['order']['shipping_details']['firstName'] . '.pdf';
        $view_name = 'pdf.' . $data['view_name'];
        unset($data['content']);
        unset($data['view_name']);

        // return view($view_name,$data);
        $pdf = PDF::loadView($view_name, $data);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream($file_name);
        // return $pdf->download($file_name);
    }

    public function gpa_letter(Request $request)
    {
        if ($request->id) {
            $id = $request->id;
            $order = Order::with('user', 'shippingDetails', 'orderdetails', 'orderdetails.product')->where(['id' => $id, 'payment_status' => 'Paid'])->first();
            if ($order) {
                $data['order']  = $order->toArray() ?? [];
                $file_name = $data['order']['id'] . '_gpa_letter_' . $data['order']['shipping_details']['firstName'] . '.pdf';
                $view_name = 'pdf.' . $request->view_name;
                // dd($data);
                // return view($view_name,$data);
                $pdf = PDF::loadView($view_name, $data);
                $pdf->setPaper('a4', 'portrait');
                // return $pdf->stream($file_name);
                return $pdf->download($file_name);
            } else {
                return redirect()->back()->with('error', 'Order not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }

    public function send_gpa_letter(Request $request)
    {
        if ($request->id) {
            $id = $request->id;
            $email = $request->email ?? '';
            if ($email) {
                $order = Order::with('user', 'shipingDetails', 'orderdetails', 'orderdetails.product')->where(['id' => $id, 'payment_status' => 'Paid'])->first();
                if ($order) {
                    $data['order']  = $order->toArray() ?? [];
                    $file_name = $data['order']['id'] . '_gpa_letter_' . $data['order']['shiping_details']['firstName'] . '.pdf';
                    $view_name = 'pdf.' . $request->view_name;

                    $pdf = PDF::loadView($view_name, $data);
                    $pdf->setPaper('a4', 'portrait');

                    // Save the PDF to a temporary location
                    $pdf_path = storage_path('app/public/' . $file_name);
                    $pdf->save($pdf_path);

                    // Send the email with the PDF attached
                    Mail::to($email)->send(new SendGpaLetter($pdf_path, $file_name));

                    // Delete the temporary PDF file
                    unlink($pdf_path);

                    return redirect()->back()->with('success', 'GPA letter sent successfully.');
                } else {
                    notify()->error("Order not found. ⚡️");
                    return redirect()->back()->with('error', 'Order not found.');
                }
            } else {
                notify()->error("Fill the email. ⚡️");
                return redirect()->back()->with('error', 'Email is required.');
            }
        } else {
            return redirect()->back()->with('error', 'Order ID is required.');
        }
    }

    public function order_bulk_print(Request $request)
    {
        if ($request->order_ids) {
            $data['role'] = $request->role ?? '';
            $orderIds = explode(',', $request->order_ids);
            $orders = Order::with('user', 'shipingDetails', 'orderdetails', 'orderdetails.product')
                ->whereIn('id', $orderIds)
                ->where('payment_status', 'Paid')
                ->get();
            if ($orders) {
                $data['orders']  = $orders->toArray() ?? [];
                $file_name = 'bulk_orders_print_' . time() . '.pdf';
                $view_name = 'pdf.' . $request->view_name;
                // return view($view_name,$data);
                $pdf = PDF::loadView($view_name, $data);
                $pdf->setPaper('a4', 'portrait');
                return $pdf->stream($file_name);
                // return $pdf->download($file_name);
            } else {
                return redirect()->back()->with('error', 'Order not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }
}
