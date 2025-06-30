<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ku', 'ar']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            background: #fff;
            max-width: 800px;
            margin: 40px auto;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.18);
            padding: 40px 48px 32px 48px;
            position: relative;
            overflow: hidden;
        }

        .invoice-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 18px;
            margin-bottom: 32px;
            text-align: center;
        }

        .company-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 18px;
        }

        .company-logo,
        .company-info img {
            height: 150px !important;
            width: 150px !important;
            border-radius: 16px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
        }

        .company-name {
            font-size: 2rem;
            font-weight: 700;
            color: #4f46e5;
            letter-spacing: 1px;
        }

        .decorative-img {
            position: absolute;
            right: -60px;
            top: 40px;
            width: 180px;
            opacity: 0.08;
            z-index: 0;
        }

        .oil-img {
            position: absolute;
            left: -60px;
            top: 60px;
            width: 160px;
            opacity: 0.13;
            z-index: 0;
        }

        .invoice-details,
        .customer-details {
            margin-bottom: 24px;
            z-index: 1;
            position: relative;
        }

        .details-label {
            color: #6b7280;
            font-size: 0.98rem;
            font-weight: 600;
            margin-right: 8px;
        }

        .details-value {
            color: #22223b;
            font-size: 1.08rem;
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
            background: #f8fafc;
            border-radius: 10px;
            overflow: hidden;
            /* Ensure table rows can break across pages */
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        /* Page break for summary and footer only if table is long */
        @media print {

            /* Remove forced page-break-before from summary and footer */
            .summary,
            footer {
                page-break-before: auto;
            }

            /* Only break after the table if it is long enough to require a new page */
            table {
                page-break-after: auto;
            }
        }

        th,
        td {
            border: 1px solid #e2e8f0;
            padding: 12px 14px;
            text-align: left;
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
        }

        td {
            font-size: 1rem;
        }

        .summary {
            margin-top: 32px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 10px;
            padding: 18px 24px;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 320px;
            float: right;
        }

        .summary strong {
            width: 120px;
            display: inline-block;
            color: #4f46e5;
        }

        .action-buttons {
            display: flex;
            gap: 18px;
            margin-top: 48px;
            justify-content: center;
        }

        .btn {
            padding: 12px 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.12);
            transition: all 0.2s;
        }

        .btn:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px) scale(1.03);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #38a169 0%, #48bb78 100%);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        }

        @media (max-width: 900px) {
            .invoice-container {
                padding: 18px;
            }

            .summary {
                float: none;
                width: 100%;
            }
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
                background: #fff !important;
                margin: 0 !important;
                padding: 0 !important;
                box-sizing: border-box !important;
            }

            *,
            *:before,
            *:after {
                box-sizing: border-box !important;
            }

            .invoice-container {
                box-shadow: none !important;
                border-radius: 0 !important;
                margin: 0 auto !important;
                padding: 10mm 8mm 8mm 8mm !important;
                width: 190mm !important;
                min-height: 277mm !important;
                max-width: 190mm !important;
                position: static !important;
                float: none !important;
                overflow: visible !important;
            }

            .company-logo {
                height: 150px !important;
                width: 150px !important;
                max-width: 100%;
                max-height: 100%;
                display: inline-block;
                position: static !important;
                margin: 0 !important;
            }

            .decorative-img,
            .oil-img {
                display: none !important;
            }

            .summary {
                float: none !important;
                width: 100% !important;
            }

            button,
            .action-buttons {
                display: none !important;
            }

            @page {
                size: A4;
                margin: 0;
            }
        }

        [dir="rtl"] body,
        [dir="rtl"] .invoice-container {
            direction: rtl;
        }

        [dir="rtl"] .invoice-header {
            flex-direction: row-reverse;
        }

        [dir="rtl"] .company-info {
            flex-direction: column;
        }

        [dir="rtl"] .summary {
            float: left;
        }

        [dir="rtl"] .details-label,
        [dir="rtl"] .details-value {
            text-align: right;
        }

        [dir="rtl"] table th,
        [dir="rtl"] table td {
            text-align: right;
        }

        /* Print-only decorative images */
        .print-decor-top,
        .print-decor-bottom {
            display: none;
        }

        @media print {

            .print-decor-top,
            .print-decor-bottom {
                display: block !important;
                position: absolute;
                z-index: 1;
                pointer-events: none;
            }

            .print-decor-top {
                top: 0;
                left: 0;
                width: 120px;
                height: auto;
            }

            .print-decor-bottom {
                bottom: 0;
                right: 0;
                width: 140px;
                height: auto;
            }
        }

        /* Print: repeat header/footer in table for multipage invoices */
        @media print {

            .invoice-header,
            .summary,
            footer {
                display: none !important;
            }

            .print-table-header {
                display: table-header-group !important;
            }

            .print-table-footer {
                display: table-footer-group !important;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container" style="position:relative;">
        <?php $invoice = session('invoice'); ?>
        @if (!$invoice)
            <form method="POST" action="{{ route('invoice.store') }}">
                @csrf
                <div class="invoice-header">
                    <div class="company-info">
                        <img src="/logo.png" alt="Logo">
                        <span class="company-name">Beston Oil</span>
                    </div>
                </div>
                <div class="invoice-details">
                    <span class="details-label">{{ __('invoice.invoice_number') }}:</span>
                    <input type="text" name="number" required style="margin-bottom:10px;">
                    <span class="details-label">{{ __('invoice.date') }}:</span>
                    <input type="date" name="date" required style="margin-bottom:10px;">
                </div>
                <div class="customer-details">
                    <span class="details-label">{{ __('invoice.customer_name') }}:</span>
                    <input type="text" name="customer_name" required style="margin-bottom:10px;">
                    <span class="details-label">{{ __('invoice.address') }}:</span>
                    <input type="text" name="address" required style="margin-bottom:10px;">
                    <span class="details-label">{{ __('invoice.phone') }}:</span>
                    <input type="text" name="phone" required style="margin-bottom:10px;">
                </div>
                <span class="details-label">{{ __('invoice.tax') }}:</span>
                <input type="number" name="tax" step="0.01" style="margin-bottom:10px;"><br>
                <table id="items-table">
                    <thead>
                        <tr>
                            <th>{{ __('invoice.item_name') }}</th>
                            <th>{{ __('invoice.quantity') }}</th>
                            <th>{{ __('invoice.unit_price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="items[0][name]" required></td>
                            <td><input type="number" name="items[0][quantity]" min="1" value="1" required>
                            </td>
                            <td><input type="number" name="items[0][unit_price]" min="0" step="0.01"
                                    value="0" required></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary" onclick="addRow()">Add Item</button>
                <div class="action-buttons">
                    <button type="submit" class="btn">Save & Print</button>
                </div>
            </form>
            <script>
                function addRow() {
                    const table = document.querySelector('#items-table tbody');
                    const rowCount = table.rows.length;
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td><input type="text" name="items[${rowCount}][name]" required></td>
                        <td><input type="number" name="items[${rowCount}][quantity]" min="1" value="1" required></td>
                        <td><input type="number" name="items[${rowCount}][unit_price]" min="0" step="0.01" value="0" required></td>
                    `;
                    table.appendChild(newRow);
                }
            </script>
        @else
            <div class="invoice-header">
                <div class="company-info">
                    <img src="/logo.png" class="company-logo" alt="Logo">
                    <span class="company-name">Beston Oil</span>
                </div>
            </div>
            <div class="invoice-details">
                <span class="details-label">{{ __('invoice.invoice_number') }}:</span>
                <span class="details-value">{{ $invoice['number'] }}</span><br>
                <span class="details-label">{{ __('invoice.date') }}:</span>
                <span class="details-value">{{ $invoice['date'] }}</span>
            </div>
            <div class="customer-details">
                <span class="details-label">{{ __('invoice.customer_name') }}:</span>
                <span class="details-value">{{ $invoice['customer_name'] }}</span><br>
                <span class="details-label">{{ __('invoice.address') }}:</span>
                <span class="details-value">{{ $invoice['address'] }}</span><br>
                <span class="details-label">{{ __('invoice.phone') }}:</span>
                <span class="details-value">{{ $invoice['phone'] }}</span>
            </div>
            <table>
                <thead class="print-table-header" style="display:none">
                    <tr>
                        <th colspan="4" style="text-align:center; padding:24px 0; background:#fff; border:none;">
                            <div style="display:flex; flex-direction:column; align-items:center;">
                                <img src="/logo.png" class="company-logo" alt="Logo" style="margin-bottom:8px;">
                                <span class="company-name"
                                    style="font-size:2rem; font-weight:700; color:#4f46e5;">Beston Oil
                                </span>
                            </div>
                        </th>
                    </tr>
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
                            <td>${{ number_format($item['unit_price'], 2) }}</td>
                            <td>${{ number_format($item_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="print-table-footer" style="display:none">
                    <tr>
                        <td colspan="4" style="padding:24px 0; background:#fff; border:none; text-align:center;">
                            <div class="summary" style="margin:0 auto; float:none; width:320px;">
                                <strong>{{ __('invoice.subtotal') }}:</strong> ${{ number_format($subtotal, 2) }}<br>
                                <strong>{{ __('invoice.tax') }}:</strong> ${{ number_format($invoice['tax'], 2) }}<br>
                                <strong>{{ __('invoice.grand_total') }}:</strong>
                                ${{ number_format($subtotal + $invoice['tax'], 2) }}<br>
                            </div>
                            <div style="margin-top:24px; color:#6b7280; font-size:15px;">
                                <div><strong>Beston Oil Shop</strong></div>
                                <div>Address: صناعە الشمالیە - مقابل کاکە جامچی</div>
                                <div>Phone: 0750 252 1551</div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="summary" style="display:none;">
                <strong>{{ __('invoice.subtotal') }}:</strong> ${{ number_format($subtotal, 2) }}<br>
                <strong>{{ __('invoice.tax') }}:</strong> ${{ number_format($invoice['tax'], 2) }}<br>
                <strong>{{ __('invoice.grand_total') }}:</strong>
                ${{ number_format($subtotal + $invoice['tax'], 2) }}<br>
            </div>
            <div class="action-buttons">
                <button class="btn" onclick="window.print()">Print</button>
                <a href="/" class="btn btn-secondary">Go Home</a>
            </div>
            <div style="margin-top:40px; text-align:center;">
                <img src="/logo.png" alt="Oil Decorative 1"
                    style="width:120px; margin:0 16px 0 0; vertical-align:middle;">
                <img src="/logo.png" alt="Oil Decorative 2"
                    style="width:120px; margin:0 16px; vertical-align:middle;">
                <img src="/logo.png" alt="Oil Decorative 3"
                    style="width:120px; margin:0 0 0 16px; vertical-align:middle;">
            </div>
            <footer
                style="margin-top:32px; padding-top:18px; border-top:1px solid #e2e8f0; text-align:center; color:#6b7280; font-size:15px;">
                <div><strong>Beston Oil Shop</strong></div>
                <div>Address: صناعە الشمالیە - مقابل کاکە جامچی</div>
                <div>Phone: 0750 252 1551</div>
            </footer>
        @endif
    </div>
</body>

</html>
