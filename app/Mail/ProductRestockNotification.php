<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductRestockNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    public function build()
    {
        $product = Product::findOrFail($this->productId); // Make sure to handle potential exceptions

        return $this->subject('Product Back in Stock')
                    ->view('emails.product_restock')
                    ->with(['product' => $product]);
    }
}
