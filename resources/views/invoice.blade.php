<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ku', 'ar']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Basic Body Styles */
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .invoice-container {
            background: #fff;
            border-radius: 18px;
            width: 100%;
            max-width: 950px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
            position: relative;
        }

        /* Language Switcher */
        .lang-switcher {
            position: absolute;
            top: 24px;
            right: 32px;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .lang-switcher label {
            color: #4f46e5;
            font-size: 0.98rem;
            font-weight: 600;
        }

        .lang-switcher select {
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            font-size: 1rem;
        }

        /* Header */
        .invoice-header {
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 24px;
            margin-bottom: 24px;
            background: #f8fafc;
            border-radius: 12px 12px 0 0;
        }

        .decorative-header-images {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 16px;
        }

        .decorative-header-images img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
        }

        .company-logo {
            height: 150px;
            width: 150px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
        }

        .company-name {
            font-size: 2rem;
            font-weight: 700;
            color: #4f46e5;
        }

        /* Customer and Invoice Info */
        .invoice-details,
        .customer-details {
            margin-bottom: 24px;
            font-size: 1rem;

        }

        .details-label {
            color: #6b7280;
            font-weight: 600;
        }

        .details-value {
            font-weight: 500;
            color: #22223b;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.08);
        }

        th,
        td {
            padding: 14px 12px;
            text-align: left;
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 1rem;
            font-weight: 700;
        }

        td {
            background: #f8fafc;
        }

        tbody tr:nth-child(odd) {
            background: #f1f5f9;
        }

        tfoot {
            background: #f8fafc;
            font-weight: 700;
            color: #4f46e5;
            text-align: right;

        }

        tfoot td {
            padding-top: 12px;
        }

        /* Decorative Images */
        .decorative-images {
            margin-top: 32px;
            display: flex;
            justify-content: center;
            gap: 24px;
        }

        .decorative-images img {
            width: 160px;
            height: 120px;
            object-fit: cover;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.15);
        }

        /* Buttons */
        .action-buttons {
            margin-top: 24px;
            display: flex;
            justify-content: center;
            gap: 16px;
        }

        .btn {
            padding: 12px 36px;
            font-size: 1rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: scale(1.03);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #38a169 0%, #48bb78 100%);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        }

        /* Footer Text */
        .footerCard {
            margin-top: 48px;
            text-align: center;
            background: #f8fafc;
            border-radius: 12px;
            padding: 16px;
            border-top: 1px solid #e2e8f0;
        }

        .footerCard div {
            color: #6b7280;
        }

        .footerCard .footer-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #4f46e5;
        }

        /* Print Styles */
        @media print {

            .lang-switcher,
            .action-buttons {
                display: none !important;
                /* Hides language selector and buttons in print view */
            }

            body {
                background: #fff;
                padding: 0;
                box-shadow: none;
            }

            .invoice-container {
                padding: 0;
                margin: 0;
                box-shadow: none;
            }
        }


        /* RTL Support for Table */
        [dir="rtl"] table {
            direction: rtl;
            /* Switches the layout to RTL */
        }

        [dir="rtl"] th,
        [dir="rtl"] td {
            text-align: right;
            /* Aligns text to the right for RTL */
        }


        .table-footer {
            background: #f8fafc;
            font-weight: 700;
            color: #4f46e5;
            padding: 16px;
            margin-top: 18px;
            border-top: 2px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-row {
            display: flex;
            justify-content: space-between;
            font-size: 1rem;
        }

        .footer-label {
            color: #6b7280;
            font-weight: 600;
        }

        .footer-value {
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- Invoice Container -->
    <div class="invoice-container">

        <!-- Language Selector -->
        <form method="GET" id="langForm" class="lang-switcher">
            <label for="lang">{{ __('invoice.language') }}:</label>
            <select name="lang" id="lang"
                onchange="if(this.value) window.location.href='/change-language/' + this.value;">
                <option value="en" @if (app()->getLocale() == 'en') selected @endif>English</option>
                <option value="ku" @if (app()->getLocale() == 'ku') selected @endif>کوردی</option>
                <option value="ar" @if (app()->getLocale() == 'ar') selected @endif>العربية</option>
            </select>
        </form>

        <!-- Header -->
        <div class="invoice-header">


            <img src="/logo.png" alt="Logo" class="company-logo">
            <div class="company-name">Beston Oil</div>
        </div>
        <!-- Decorative Images Above Invoice Header -->
        <div class="decorative-header-images">
            <img src="/img4.jpeg" alt="Header Decorative 1">
            <img src="/img5.jpeg" alt="Header Decorative 2">
            <img src="/img6.jpeg" alt="Header Decorative 3">
        </div>
        <!-- Invoice Details -->
        <div class="invoice-details">
            <p><span class="details-label">{{ __('invoice.invoice_number') }}:</span>
                <span class="details-value">{{ $invoice['number'] }}</span>
            </p>
            <p><span class="details-label">{{ __('invoice.date') }}:</span>
                <span class="details-value">{{ $invoice['date'] }}</span>
            </p>
        </div>

        <!-- Customer Details -->
        <div class="customer-details">
            <p><span class="details-label">{{ __('invoice.customer_name') }}:</span>
                <span class="details-value">{{ $invoice['customer_name'] }}</span>
            </p>
            <p><span class="details-label">{{ __('invoice.address') }}:</span>
                <span class="details-value">{{ $invoice['address'] }}</span>
            </p>
            <p><span class="details-label">{{ __('invoice.phone') }}:</span>
                <span class="details-value">{{ $invoice['phone'] }}</span>
            </p>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>{{ __('invoice.item_name') }}</th>
                    <th>{{ __('invoice.quantity') }}</th>
                    <th>{{ __('invoice.unit_price') }}</th>
                    <th>{{ __('invoice.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach ($invoice['items'] as $item)
                    @php
                        $item_total = $item['quantity'] * $item['unit_price'];
                        $subtotal += $item_total;
                    @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ __('invoice.' . $invoice['currency']) }}{{ number_format($item['unit_price'], 2) }}
                        </td>
                        <td>{{ __('invoice.' . $invoice['currency']) }}{{ number_format($item_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <div class="table-footer">
            <div class="footer-row">
                <span class="footer-label">{{ __('invoice.subtotal') }}:</span>
                <span
                    class="footer-value">{{ __('invoice.' . $invoice['currency']) }}{{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="footer-row">
                <span class="footer-label">{{ __('invoice.tax') }}:</span>
                <span
                    class="footer-value">{{ __('invoice.' . $invoice['currency']) }}{{ number_format($invoice['tax'], 2) }}</span>
            </div>
            <div class="footer-row">
                <span class="footer-label">{{ __('invoice.total') }}:</span>
                <span
                    class="footer-value">{{ __('invoice.' . $invoice['currency']) }}{{ number_format($subtotal + $invoice['tax'], 2) }}</span>
            </div>
        </div>
        <!-- Decorative Images -->
        <div class="decorative-images">
            <img src="/img1.jpeg" alt="Decorative 1">
            <img src="/img2.jpeg" alt="Decorative 2">
            <img src="/img3.jpeg" alt="Decorative 3">
        </div>

        <!-- Footer -->
        <div class="footerCard">
            <div class="footer-title">Beston Oil</div>
            <div>{{ __('invoice.address') }}: صناعە الشمالیە - مقابل کاکە جامچی</div>
            <div>{{ __('invoice.phone') }}: 0750 252 1551</div>
            <div>{{ __('invoice.currency') }}: {{ $invoice['currency'] }}</div>
        </div>

        <!-- Actions -->
        <div class="action-buttons">
            <button class="btn" onclick="window.print()">🖨️ {{ __('invoice.print') }}</button>
            <a href="/" class="btn btn-secondary">🏠 {{ __('invoice.go_home') }}</a>
        </div>
    </div>
</body>

</html>
