<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $order->loadMissing(['user', 'room.roomType']);
        $this->order = $order;
    }

    public function build()
    {
        $status = strtolower((string) ($this->order->status ?? ''));

        $subject = match ($status) {
            'confirmed' => 'Booking Confirmed - Villa Diana Hotel',
            'cancelled' => 'Booking Cancelled - Villa Diana Hotel',
            default => 'Booking Status Update - Villa Diana Hotel',
        };

        return $this->subject($subject)
            ->view('emails.booking_status')
            ->text('emails.booking_status_text');
    }
}
