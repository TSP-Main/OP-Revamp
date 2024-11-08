<?php

namespace App\Jobs;

use App\Mail\ProductRestockNotification;
use App\Models\Product;
use App\Models\ProductNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUsersOfRestock implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function handle()
    {
        // Fetch notifications for products that are back in stock
        $notifications = ProductNotification::whereHas('product', function ($query) {
            $query->where('stock', '>', 0); // Ensure this column exists
        })->get();

        foreach ($notifications as $notification) {
            Mail::to($notification->email)->send(new ProductRestockNotification($notification->product_id));
        }
    }
}
