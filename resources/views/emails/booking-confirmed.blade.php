<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmed</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
            <div style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); padding: 32px; text-align: center;">
                <h1 style="margin: 0; color: white; font-size: 24px;">Booking Confirmed!</h1>
                <p style="margin: 8px 0 0; color: rgba(255,255,255,0.9); font-size: 14px;">Your trip has been booked successfully</p>
            </div>

            <div style="padding: 32px;">
                <p style="margin: 0 0 24px; color: #374151; font-size: 16px;">
                    Dear {{ $order->customer->name ?? 'Valued Customer' }},
                </p>
                <p style="margin: 0 0 24px; color: #6b7280; font-size: 14px; line-height: 1.6;">
                    Thank you for booking with TravelAI! Your reservation has been confirmed. Below are the details of your upcoming trip.
                </p>

                <div style="background: #f9fafb; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                    <h2 style="margin: 0 0 16px; color: #111827; font-size: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                        Trip Details
                    </h2>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Order ID</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">#{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Date & Time</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{ $order->scheduled_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Vehicle</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{ ucfirst($order->vehicle->type ?? 'Standard') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Distance</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{ number_format($order->distance_km, 1) }} km</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Total Price</td>
                            <td style="padding: 8px 0; color: #4f46e5; font-size: 16px; font-weight: 700; text-align: right;">RM {{ number_format($order->total_price, 2) }}</td>
                        </tr>
                    </table>
                </div>

                <div style="background: #f9fafb; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                    <h2 style="margin: 0 0 16px; color: #111827; font-size: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                        Route Information
                    </h2>
                    <div style="margin-bottom: 16px;">
                        <p style="margin: 0 0 4px; color: #6b7280; font-size: 12px; text-transform: uppercase;">Pickup</p>
                        <p style="margin: 0; color: #111827; font-size: 14px;">{{ $order->pickup_address }}</p>
                    </div>
                    <div>
                        <p style="margin: 0 0 4px; color: #6b7280; font-size: 12px; text-transform: uppercase;">Drop-off</p>
                        <p style="margin: 0; color: #111827; font-size: 14px;">{{ $order->dropoff_address }}</p>
                    </div>
                </div>

                @if($order->flight_number)
                <div style="background: #fef3c7; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                    <p style="margin: 0; color: #92400e; font-size: 14px;">
                        <strong>Flight Number:</strong> {{ $order->flight_number }}
                    </p>
                </div>
                @endif

                <div style="text-align: center; margin: 32px 0;">
                    <a href="{{ route('booking.confirmation', $order->id) }}" style="display: inline-block; background: #4f46e5; color: white; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px;">
                        View Booking Details
                    </a>
                </div>

                <p style="margin: 0; color: #6b7280; font-size: 12px; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 20px;">
                    If you have any questions, please contact us at support@travelai.com
                </p>
            </div>
        </div>

        <p style="text-align: center; color: #9ca3af; font-size: 12px; margin-top: 20px;">
            © {{ date('Y') }} TravelAI Platform. All rights reserved.
        </p>
    </div>
</body>
</html>
