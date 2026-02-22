<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DriverAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Trip Assigned - ' . $this->order->scheduled_at->format('d M Y, h:i A'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.driver-assigned',
        );
    }
}
