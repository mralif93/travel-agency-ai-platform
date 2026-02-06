<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trip Details - #{{ $order->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
        }

        .order-id {
            font-size: 14px;
            color: #6b7280;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #111827;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 10px;
        }

        .route-container {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .route-item {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .value {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 5px;
        }

        .sub-value {
            font-size: 12px;
            color: #6b7280;
        }

        .driver-info {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .payment-summary {
            width: 100%;
            border-collapse: collapse;
        }

        .payment-summary td {
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .payment-summary tr:last-child td {
            border-bottom: none;
            font-weight: bold;
            font-size: 16px;
            padding-top: 15px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 999px;
            background-color: #f3f4f6;
            color: #374151;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            padding: 20px;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">TravelAI Booking</div>
        <div class="order-id">Order #{{ substr($order->id, 0, 8) }}<br>{{ $order->created_at->format('M d, Y') }}</div>
    </div>

    <div class="section">
        <div class="section-title">Route Information</div>
        <div class="route-container">
            <div class="route-item">
                <div class="label" style="color: #10b981;">Pickup</div>
                <div class="value">{{ $order->pickup_location }}</div>
                <div class="sub-value">{{ $order->pickup_address }}</div>
            </div>
            <div class="route-item">
                <div class="label" style="color: #ef4444;">Dropoff</div>
                <div class="value">{{ $order->dropoff_location }}</div>
                <div class="sub-value">{{ $order->dropoff_address }}</div>
            </div>
        </div>
        <div class="route-container" style="margin-top: 15px;">
            <div class="route-item">
                <div class="label">Configured Date</div>
                <div class="value">{{ $order->scheduled_at ? $order->scheduled_at->format('l, F j, Y') : 'ASAP' }}</div>
            </div>
            <div class="route-item">
                <div class="label">Time</div>
                <div class="value">{{ $order->scheduled_at ? $order->scheduled_at->format('h:i A') : 'N/A' }}</div>
            </div>
        </div>
    </div>

    @if($order->vehicle && $order->vehicle->driver)
        <div class="section">
            <div class="section-title">Driver & Vehicle</div>
            <div class="driver-info">
                <div class="route-container" style="margin-bottom: 0;">
                    <div class="route-item">
                        <div class="label">Driver</div>
                        <div class="value">{{ $order->vehicle->driver->name }}</div>
                    </div>
                    <div class="route-item">
                        <div class="label">Vehicle</div>
                        <div class="value">{{ $order->vehicle->model }} <span
                                style="font-weight: normal; color: #6b7280;">({{ $order->vehicle->license_plate }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="section">
        <div class="section-title">Payment Summary</div>
        <table class="payment-summary">
            <tr>
                <td>Base Fare</td>
                <td style="text-align: right;">RM{{ number_format($order->base_price ?? $order->total_price * 0.8, 2) }}
                </td>
            </tr>
            @if(isset($order->service_fee))
                <tr>
                    <td>Service Fee</td>
                    <td style="text-align: right;">RM{{ number_format($order->service_fee, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td>Total</td>
                <td style="text-align: right; color: #4f46e5;">RM{{ number_format($order->total_price, 2) }}</td>
            </tr>
        </table>
        <div style="margin-top: 20px; text-align: right;">
            <span class="status-badge">Status: {{ ucfirst($order->payment_status ?? 'unpaid') }}</span>
        </div>
    </div>

    <div class="section" style="text-align: center; margin-top: 50px;">
        <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(120)->generate($order->id)) }} ">
        <p style="font-size: 10px; color: #9ca3af; margin-top: 5px;">Scan to verify trip</p>
    </div>

    <div class="footer">
        Generated on {{ now()->format('Y-m-d H:i:s') }} | TravelAI Portal
    </div>
</body>

</html>