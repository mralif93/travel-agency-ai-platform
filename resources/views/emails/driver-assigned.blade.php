<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Trip Assigned</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
            <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 32px; text-align: center;">
                <h1 style="margin: 0; color: white; font-size: 24px;">New Trip Assigned</h1>
                <p style="margin: 8px 0 0; color: rgba(255,255,255,0.9); font-size: 14px;">You have a new passenger pickup</p>
            </div>

            <div style="padding: 32px;">
                <p style="margin: 0 0 24px; color: #374151; font-size: 16px;">
                    Hello {{ $order->vehicle->driver->name ?? 'Driver' }},
                </p>
                <p style="margin: 0 0 24px; color: #6b7280; font-size: 14px; line-height: 1.6;">
                    A new trip has been assigned to you. Please review the details below and ensure you arrive at the pickup location on time.
                </p>

                <div style="background: #f0fdf4; border-left: 4px solid #10b981; padding: 16px; margin-bottom: 24px; border-radius: 0 8px 8px 0;">
                    <p style="margin: 0; color: #047857; font-size: 14px;">
                        <strong>Scheduled:</strong> {{ $order->scheduled_at->format('d M Y, h:i A') }}
                    </p>
                </div>

                <div style="background: #f9fafb; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                    <h2 style="margin: 0 0 16px; color: #111827; font-size: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                        Passenger Details
                    </h2>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Name</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{ $order->customer->name ?? 'Guest' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Phone</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; text-align: right;">{{ $order->customer->phone ?? 'N/A' }}</td>
                        </tr>
                        @if($order->flight_number)
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Flight</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{ $order->flight_number }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <div style="background: #f9fafb; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                    <h2 style="margin: 0 0 16px; color: #111827; font-size: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                        Route Information
                    </h2>
                    <div style="margin-bottom: 16px;">
                        <p style="margin: 0 0 4px; color: #10b981; font-size: 12px; font-weight: 600; text-transform: uppercase;">Pickup Location</p>
                        <p style="margin: 0; color: #111827; font-size: 14px;">{{ $order->pickup_address }}</p>
                    </div>
                    <div>
                        <p style="margin: 0 0 4px; color: #ef4444; font-size: 12px; font-weight: 600; text-transform: uppercase;">Drop-off Location</p>
                        <p style="margin: 0; color: #111827; font-size: 14px;">{{ $order->dropoff_address }}</p>
                    </div>
                </div>

                <div style="background: #f9fafb; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                    <h2 style="margin: 0 0 16px; color: #111827; font-size: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                        Trip Summary
                    </h2>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Distance</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{ number_format($order->distance_km, 1) }} km</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Order ID</td>
                            <td style="padding: 8px 0; color: #111827; font-size: 14px; text-align: right;">#{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Fare</td>
                            <td style="padding: 8px 0; color: #10b981; font-size: 16px; font-weight: 700; text-align: right;">RM {{ number_format($order->total_price, 2) }}</td>
                        </tr>
                    </table>
                </div>

                @if($order->remarks)
                <div style="background: #fef3c7; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                    <p style="margin: 0 0 4px; color: #92400e; font-size: 12px; font-weight: 600; text-transform: uppercase;">Special Instructions</p>
                    <p style="margin: 0; color: #78350f; font-size: 14px;">{{ $order->remarks }}</p>
                </div>
                @endif

                <div style="text-align: center; margin: 32px 0;">
                    <a href="{{ route('dashboard.driver') }}" style="display: inline-block; background: #10b981; color: white; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px;">
                        View in Dashboard
                    </a>
                </div>

                <p style="margin: 0; color: #6b7280; font-size: 12px; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 20px;">
                    If you have any issues with this assignment, please contact your supervisor.
                </p>
            </div>
        </div>

        <p style="text-align: center; color: #9ca3af; font-size: 12px; margin-top: 20px;">
            © {{ date('Y') }} TravelAI Platform. All rights reserved.
        </p>
    </div>
</body>
</html>
