<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }

        .header {
            margin-bottom: 40px;
        }

        .header table {
            width: 100%;
        }

        .header .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .header .meta {
            text-align: right;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            border-bottom: 2px solid #eee;
            margin-bottom: 15px;
            padding-bottom: 5px;
            text-transform: uppercase;
            color: #555;
        }

        .details-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 8px 0;
            vertical-align: top;
        }

        .details-table .label {
            font-weight: bold;
            width: 120px;
            color: #666;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            text-align: left;
            background: #f9f9f9;
            padding: 10px;
            border-bottom: 2px solid #eee;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .items-table .total-row td {
            border-top: 2px solid #333;
            border-bottom: none;
            font-weight: bold;
            font-size: 16px;
        }

        .qr-code {
            text-align: center;
            margin-top: 50px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #aaa;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <table>
                <tr>
                    <td>
                        <div class="title">INVOICE</div>
                        <div>TravelAI Platform</div>
                    </td>
                    <td class="meta">
                        <div><strong>Invoice #:</strong> {{ strtoupper(substr($order->id, 0, 8)) }}</div>
                        <div><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</div>
                        <div><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section-title">Customer Details</div>
        <table class="details-table">
            <tr>
                <td class="label">Name:</td>
                <td>{{ $order->customer->name }}</td>
            </tr>
            <tr>
                <td class="label">Email:</td>
                <td>{{ $order->customer->email }}</td>
            </tr>
            <tr>
                <td class="label">Phone:</td>
                <td>{{ $order->customer->phone }}</td>
            </tr>
        </table>

        <div class="section-title">Trip Details</div>
        <table class="details-table">
            <tr>
                <td class="label">Vehicle:</td>
                <td>{{ $order->vehicle->make }} {{ $order->vehicle->model }} ({{ $order->vehicle->type }})</td>
            </tr>
            <tr>
                <td class="label">Pickup:</td>
                <td>
                    {{ $order->pickup_address }}<br>
                    <small>{{ $order->scheduled_at->format('d M Y, h:i A') }}</small>
                </td>
            </tr>
            <tr>
                <td class="label">Dropoff:</td>
                <td>{{ $order->dropoff_address }}</td>
            </tr>
            @if($order->flight_number)
                <tr>
                    <td class="label">Flight No:</td>
                    <td>{{ $order->flight_number }}</td>
                </tr>
            @endif
        </table>

        <div class="section-title">Payment Summary</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Transport Service - {{ $order->distance_km }} km</td>
                    <td style="text-align: right;">RM {{ number_format($order->total_price, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Paid</td>
                    <td style="text-align: right;">RM {{ number_format($order->total_price, 2) }}</td>
                </tr>
            </tbody>
        </table>

        @if(isset($qrCode))
            <div class="qr-code">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" width="100">
                <div style="margin-top: 5px; font-size: 10px; color: #999;">Scan to verify</div>
            </div>
        @endif

        <div class="footer">
            Thank you for choosing TravelAI!<br>
            This is a computer-generated invoice and requires no signature.
        </div>
    </div>
</body>

</html>