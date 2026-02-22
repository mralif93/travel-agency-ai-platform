<?php

namespace App\Services;

use App\Mail\BookingConfirmed;
use App\Mail\DriverAssigned;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function sendBookingConfirmation(Order $order): void
    {
        if ($order->customer && $order->customer->email) {
            Mail::to($order->customer->email)->queue(new BookingConfirmed($order));
        }
    }

    public function sendOrderStatusUpdate(Order $order, string $previousStatus): void
    {
        if ($order->customer && $order->customer->email) {
            Mail::to($order->customer->email)->queue(new OrderStatusUpdated($order, $previousStatus));
        }
    }

    public function sendDriverAssignment(Order $order): void
    {
        if ($order->vehicle && $order->vehicle->driver && $order->vehicle->driver->email) {
            Mail::to($order->vehicle->driver->email)->queue(new DriverAssigned($order));
        }
    }
}
