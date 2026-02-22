<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Status Updated</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
            @php
                $statusColors = [
                    'pending' => '#f59e0b',
                    'confirmed' => '#3b82f6',
                    'active' => '#10b981',
                    'completed' => '#059669',
                    'cancelled' => '#ef4444',
                ];
                $color = $statusColors[$order->status] ?? '#6b7280';
            @endphp

            <div style="background: linear-gradient(135deg, {{ $color }} 0%, {{ $color }} 100%); padding: 32px; text-align: center;">
                <h1 style="margin: 0; color: white; font-size: 24px; text-transform: capitalize;">{{ $order->status }}</h1>
                <p style="margin: 8px 0 0; color: rgba(255,255,255,0.9); font-size: 14px;">Your order status has been updated</p>
            </div>

            <div style="padding: 32px;">
                <p style="margin: 0 0 24px; color: #374151; font-size: 16px;">
                    Dear {{ $order->customer->name ?? 'Valued Customer' }},
                </p>
                <p style="margin: 0 0 24px; color: #6b7280; font-size: 14px; line-height: 1.6;">
                    Your trip order <strong>#{{ $order->id }}</strong> status has been updated from <strong>{{ ucfirst($previousStatus) }}</strong> to <strong style="color: {{ $color }}">{{ ucfirst($order->status) }}</strong>.
                </p>

                @if($order->status === 'active')
                <div style="background: #ecfdf5; border-left: 4px solid #10b981; padding: 16px; margin-bottom: 24px; border-radius: 0 8px 8px 0;">
                    <p style="margin: 0; color: #047857; font-size: 14px; font-weight: 600;">
                        Your driver is on the way! Please be ready at the pickup location.
                    </p>
                </div>
                @endif

                @if($order->status === 'completed')
                <div style="background: #ecfdf5; border-left: 4px solid #059669; padding: 16px; margin-bottom: 24px; border-radius: 0 8px 8px 0;">
                    <p style="margin: 0; color: #047857; font-size: 14px; font-weight: 600;">
                        Thank you for traveling with us! We hope you had a great journey.
                    </p>
                </div>
                @endif

                @if($order->status === 'cancelled')
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 16px; margin-bottom: 24px; border-radius: 0 8px 8px 0;">
                    <p style="margin: 0; color: #b91c1c; font-size: 14px; font-weight: 600;">
                        Your booking has been cancelled. If this was unexpected, please contact support.
                    </p>
                </div>
                @endif

                <div style="background: #f9fafb; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                    <h2 style="margin: 0 0 16px; color: #111827; font-size: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                        Trip Summary
                    </h2>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Order ID</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">#{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Pickup</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; text-align: right;">{{ Illuminate\Support\Str::limit($order->pickup_address, 40) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Drop-off</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; text-align: right;">{{ Illuminate\Support\Str::limit($order->dropoff_address, 40) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Total</td>
                            <td style="padding: 8px 0; color: #4f46e5; font-size: 14px; font-weight: 700; text-align: right;">RM {{ number_format($order->total_price, 2) }}</td>
                        </tr>
                    </table>
                </div>

                <div style="text-align: center; margin: 32px 0;">
                    <a href="{{ route('booking.confirmation', $order->id) }}" style="display: inline-block; background: #4f46e5; color: white; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px;">
                        View Order Details
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
