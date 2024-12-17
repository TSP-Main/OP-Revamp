<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShippedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $shippingDetail;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     * @param  \App\Models\ShippingDetail  $shippingDetail
     * @return void
     */
    public function __construct($order, $shippingDetail)
    {
        $this->order = $order;
        $this->shippingDetail = $shippingDetail;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Your Order Has Been Shipped!',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.shipped', // Assuming you will create this view
            with: [
                'order' => $this->order,
                'tracking_no' => $this->shippingDetail->tracking_no,
                'order_identifier' => $this->shippingDetail->order_identifier,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
