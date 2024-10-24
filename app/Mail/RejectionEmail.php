<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $hcpRemarks;

    public function __construct($order, $hcpRemarks)
    {
        $this->order = $order;
        $this->hcpRemarks = $hcpRemarks;
    }

    public function build()
    {
        return $this->subject('Order Rejection Notification')
                    ->view('emails.rejection') // Create a corresponding Blade view for the email
                    ->with([
                        'order' => $this->order,
                        'hcpRemarks' => $this->hcpRemarks,
                    ]);
    }
}
