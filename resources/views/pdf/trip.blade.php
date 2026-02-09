<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Booking Confirmation</title>
    <style>
        /* PDF Page Setup - Strictly 1 Page layout */
        @page {
            margin: 20px 25px 20px 25px;
        }

        body {
            font-family: sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            color: #333;
            position: relative;
        }

        /* Master Table for structure */
        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        td {
            vertical-align: top;
        }

        /* Header */
        .header-logo {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 2px;
        }

        .header-sub {
            font-size: 9px;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            text-align: right;
            color: #333;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .bg-paid {
            background: #dcfce7;
            color: #166534;
        }

        .bg-pending {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Info Boxes */
        .info-box {
            border: 1px solid #ddd;
            background: #fcfcfc;
            padding: 8px;
            margin: 10px 0;
            border-radius: 4px;
        }

        .info-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
        }

        .info-val {
            font-size: 11px;
            font-weight: bold;
            color: #000;
            margin-top: 2px;
        }

        /* Section Titles */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
            margin: 10px 0 8px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }

        /* Trip Details */
        .trip-item {
            margin-bottom: 10px;
        }

        .trip-label {
            font-size: 9px;
            font-weight: bold;
            color: #666;
            margin-bottom: 2px;
        }

        .trip-val {
            font-size: 11px;
            font-weight: bold;
            color: #000;
        }

        .trip-sub {
            font-size: 9px;
            color: #555;
        }

        .trip-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            color: white;
            text-align: center;
            line-height: 20px;
            font-size: 10px;
            font-weight: bold;
            margin-right: 8px;
            vertical-align: top;
        }

        /* 2-Column Tables */
        .cols-gap {
            width: 20px;
        }

        /* Details Grid */
        .detail-row td {
            padding: 3px 0;
            border-bottom: 1px dashed #eee;
            font-size: 10px;
        }

        .detail-row:last-child td {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
        }

        .detail-val {
            text-align: right;
            font-weight: bold;
            color: #000;
        }

        /* Totals */
        .total-row td {
            padding: 6px 0;
            border-top: 2px solid #333;
            font-size: 12px;
            font-weight: bold;
        }

        /* 
           Fixed Footer at Bottom 
           Using 'position: fixed' with explicit bottom coordinate works in DOMPDF 
           as long as page margins are sufficient.
        */
        .footer {
            position: fixed;
            bottom: 0px;
            /* Adjusting for page margin visual */
            left: 0;
            right: 0;
            height: 25px;
            text-align: center;
            color: #777;
            font-size: 9px;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            background: #fff;
        }
    </style>
</head>

<body>

    <!-- Fixed Footer -->
    <div class="footer">
        <div>support@travelai.com &bull; +60 3-1234 5678 &bull; www.travelai.com</div>
        <div style="margin-top: 2px;">Thank you for choosing TRAVELAI Premium Chauffeur Service</div>
    </div>

    <!-- Header -->
    <table style="margin-bottom: 10px;">
        <tr>
            <td style="width: 60%;">
                <div class="header-logo">TRAVELAI</div>
                <div class="header-sub">Premium Chauffeur Service</div>
                <div style="margin-top: 8px; font-size: 10px; color: #444;">
                    <strong>Invoice No:</strong> #{{ substr($order->id, 0, 8) }}<br>
                    <strong>Booking Ref:</strong> {{ strtoupper(substr($order->id, 0, 13)) }}
                </div>
            </td>
            <td style="width: 40%; text-align: right;">
                <div class="invoice-title">INVOICE</div>
                <div>
                    <!-- Use order status as proxy for payment since payment col missing -->
                    @php
                        $statusLabel = $order->status === 'completed' || $order->status === 'confirmed' ? 'PAID' : 'PENDING';
                        $badgeClass = $order->status === 'completed' || $order->status === 'confirmed' ? 'bg-paid' : 'bg-pending';
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ $statusLabel }}
                    </span>
                </div>
                <div style="margin-top: 4px; font-size: 10px; color: #444;">
                    {{ $order->created_at->format('M d, Y') }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Info Bar -->
    <div class="info-box">
        <table>
            <tr>
                <td style="text-align: center; width: 25%; border-right: 1px solid #ddd;">
                    <div class="info-label">Date</div>
                    <div class="info-val">{{ $order->scheduled_at ? $order->scheduled_at->format('M d, Y') : 'ASAP' }}
                    </div>
                </td>
                <td style="text-align: center; width: 25%; border-right: 1px solid #ddd;">
                    <div class="info-label">Time</div>
                    <div class="info-val">{{ $order->scheduled_at ? $order->scheduled_at->format('h:i A') : '-' }}</div>
                </td>
                <td style="text-align: center; width: 25%; border-right: 1px solid #ddd;">
                    <div class="info-label">Passengers</div>
                    <div class="info-val">{{ $order->passengers ?? '2' }} Adults</div>
                </td>
                <td style="text-align: center; width: 25%;">
                    <div class="info-label">Trip Status</div>
                    <div class="info-val">{{ ucfirst($order->status ?? 'Pending') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Professional Itinerary Section -->
    <div style="margin-top: 20px; margin-bottom: 20px;">

        <!-- Header -->
        <table style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td style="vertical-align: middle;">
                    <div
                        style="font-size: 13px; font-weight: 800; color: #1e3a8a; letter-spacing: 0.5px; text-transform: uppercase;">
                        Trip Itinerary
                    </div>
                    <div style="height: 3px; width: 40px; background: #2563eb; margin-top: 4px; border-radius: 2px;">
                    </div>
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(55)->generate($order->id)) }}"
                        style="vertical-align: middle; border: 3px solid #fff; box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);">
                </td>
            </tr>
        </table>

        <!-- Timeline Table -->
        <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <!-- Pickup -->
            <tr>
                <!-- Timeline Column -->
                <td style="width: 40px; vertical-align: top; padding: 0; position: relative;">
                    <!-- Dot -->
                    <div
                        style="width: 12px; height: 12px; background: #2563eb; border-radius: 50%; border: 3px solid #dbeafe; position: relative; z-index: 10; margin: 0 auto;">
                    </div>
                    <!-- Line: Fixed height instead of 100% to prevent page break issues -->
                    <div style="width: 2px; background: #e2e8f0; margin: 0 auto; height: 50px;"></div>
                </td>

                <!-- Content Column -->
                <td style="vertical-align: top; padding-left: 15px; padding-bottom: 20px;">
                    <div style="margin-top: -2px;">
                        <span
                            style="background: #dbeafe; color: #1e40af; font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 10px; text-transform: uppercase; letter-spacing: 0.5px;">Pickup</span>
                    </div>

                    <div style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 5px;">
                        {{ $order->pickup_location }}
                    </div>

                    <div style="font-size: 10px; color: #64748b; margin-top: 2px; line-height: 1.3;">
                        {{ $order->pickup_address }}
                    </div>

                    <div style="margin-top: 6px;">
                        <div
                            style="font-size: 10px; font-weight: 600; color: #334155; background: #f8fafc; padding: 4px 6px; border: 1px solid #e2e8f0; border-radius: 4px; display: inline-block;">
                            📅 {{ $order->scheduled_at ? $order->scheduled_at->format('D, M d • h:i A') : 'TBD' }}
                            <span style="color: #94a3b8; font-weight: 400; font-size: 9px; margin-left: 4px;">(Wait time
                                included)</span>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- Dropoff -->
            <tr>
                <!-- Timeline Column -->
                <td style="width: 40px; vertical-align: top; padding: 0; position: relative;">
                    <!-- Dot -->
                    <div
                        style="width: 12px; height: 12px; background: #7c3aed; border-radius: 50%; border: 3px solid #f3e8ff; position: relative; z-index: 10; margin: 0 auto;">
                    </div>
                </td>

                <!-- Content Column -->
                <td style="vertical-align: top; padding-left: 15px;">
                    <div style="margin-top: -2px;">
                        <span
                            style="background: #f3e8ff; color: #6b21a8; font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 10px; text-transform: uppercase; letter-spacing: 0.5px;">Dropoff</span>
                    </div>

                    <div style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 5px;">
                        {{ $order->dropoff_location }}
                    </div>

                    <div style="font-size: 10px; color: #64748b; margin-top: 2px; line-height: 1.3;">
                        {{ $order->dropoff_address }}
                    </div>

                    @if($order->distance_km > 0)
                        <div style="margin-top: 6px;">
                            <div
                                style="display: inline-block; font-size: 10px; color: #64748b; background: #f1f5f9; padding: 3px 6px; border-radius: 4px;">
                                📏 Est. Distance: <strong>{{ $order->distance_km }} km</strong>
                            </div>
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- 2 Cols: Driver & Payment -->
    <table>
        <tr>
            <td style="width: 48%; padding: 10px; border: 1px solid #ddd; background: #fff; border-radius: 4px;">
                <div
                    style="font-weight: bold; color: #1e3a8a; margin-bottom: 6px; border-bottom: 1px solid #eee; padding-bottom: 3px; font-size: 10px;">
                    DRIVER INFORMATION
                </div>
                @if($order->vehicle && $order->vehicle->driver)
                    <table style="width: 100%;">
                        <tr class="detail-row">
                            <td class="detail-label">Name</td>
                            <td class="detail-val">{{ $order->vehicle->driver->name }}</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">Contact</td>
                            <td class="detail-val">{{ $order->vehicle->driver->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">Vehicle</td>
                            <td class="detail-val">{{ $order->vehicle->model }}</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">Plate</td>
                            <td class="detail-val">{{ $order->vehicle->license_plate }}</td>
                        </tr>
                    </table>
                @else
                    <div style="color: #999; text-align: center; padding: 12px 0; font-size: 10px;">Details Pending</div>
                @endif
            </td>

            <td class="cols-gap"></td>

            <td style="width: 48%; padding: 10px; border: 1px solid #ddd; background: #fff; border-radius: 4px;">
                <div
                    style="font-weight: bold; color: #1e3a8a; margin-bottom: 6px; border-bottom: 1px solid #eee; padding-bottom: 3px; font-size: 10px;">
                    PAYMENT DETAILS
                </div>
                <table style="width: 100%;">
                    @php
                        $base = isset($order->base_price) ? $order->base_price : $order->total_price * 0.8;
                        $tax = $order->total_price - $base;
                    @endphp
                    <tr class="detail-row">
                        <td class="detail-label">Base Fare</td>
                        <td class="detail-val">RM {{ number_format($base, 2) }}</td>
                    </tr>
                    <tr class="detail-row">
                        <td class="detail-label">Taxes & Fees</td>
                        <td class="detail-val">RM {{ number_format($tax, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td>TOTAL</td>
                        <td style="text-align: right;">RM {{ number_format($order->total_price, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>