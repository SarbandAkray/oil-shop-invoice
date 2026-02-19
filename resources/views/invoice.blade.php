<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ku', 'ar']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('invoice.tax_invoice') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #d0d0d0;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .invoice-wrapper {
            background: #fff;
            width: 100%;
            max-width: 900px;
            margin: 32px auto;
            padding: 28px 32px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.18);
        }

        /* Language Switcher */
        .lang-switcher {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            align-items: center;
            margin-bottom: 14px;
        }
        [dir="rtl"] .lang-switcher { justify-content: flex-start; }
        .lang-switcher label { font-size: 0.85rem; color: #555; font-weight: 600; }
        .lang-switcher select {
            padding: 4px 8px;
            border-radius: 3px;
            border: 1px solid #ccc;
            font-size: 0.88rem;
        }

        /*
         * Print structure: on screen these are plain blocks.
         * In print they become table-header-group / table-footer-group
         * so the browser repeats them on every page automatically.
         */
        .print-outer  { display: block; width: 100%; }
        .print-header { display: block; }
        .print-footer { display: block; }
        .print-body   { display: block; }
        .print-row    { display: block; }
        .print-cell   { display: block; }

        /* Header */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 14px;
            border-bottom: 2px solid #222;
        }
        .header-left {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        [dir="rtl"] .header-left { align-items: flex-end; }
        .company-logo { height: 75px; width: auto; object-fit: contain; }
        .company-name-text {
            font-size: 1.05rem;
            font-weight: 700;
            color: #222;
            margin-top: 5px;
        }
        .header-right {
            text-align: right;
            font-size: 0.82rem;
            color: #444;
            line-height: 1.7;
        }
        [dir="rtl"] .header-right { text-align: left; }
        .header-right .trilang-group { margin-bottom: 4px; }
        .header-right .trilang-group + .trilang-group { border-top: 1px dashed #ccc; padding-top: 4px; }

        /* Tax Invoice Title */
        .invoice-title-bar {
            text-align: center;
            font-size: 1.75rem;
            font-weight: 700;
            color: #222;
            border-top: 2px solid #222;
            border-bottom: 2px solid #222;
            padding: 9px 0;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border: 2px solid #222;
            direction: ltr;
        }
        .info-block { padding: 12px 14px; direction: inherit; }
        .info-block + .info-block { border-left: 2px solid #222; }
        [dir="rtl"] .info-block { direction: rtl; }
        [dir="rtl"] .info-block + .info-block { border-left: none; border-right: 2px solid #222; }

        .info-block-title {
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
            color: #222;
        }
        .info-row {
            display: flex;
            gap: 8px;
            padding: 4px 0;
            font-size: 0.92rem;
        }
        .info-label { color: #555; font-weight: 600; white-space: nowrap; }
        .info-value { color: #222; }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #1565c0;
        }
        .items-table thead { border-top: 2px solid #1565c0; }
        .items-table th {
            background: #1565c0;
            color: #ffd600;
            padding: 10px 12px;
            font-size: 0.88rem;
            font-weight: 600;
            text-align: left;
            border: 2px solid #1565c0;
        }
        [dir="rtl"] .items-table th { text-align: right; }
        .items-table td {
            padding: 9px 12px;
            border: 2px solid #90bce8;
            font-size: 0.92rem;
            background: #fff;
        }
        .items-table tbody tr:nth-child(even) td { background: #f0f7ff; }
        [dir="rtl"] .items-table { direction: rtl; }
        [dir="rtl"] .items-table th,
        [dir="rtl"] .items-table td { text-align: right; }

        /* Bottom row: Notes + Totals */
        .bottom-row {
            display: flex;
            border: 2px solid #222;
            border-top: none;
        }
        .notes-col {
            flex: 1;
            padding: 12px 14px;
            border-right: 2px solid #222;
        }
        [dir="rtl"] .notes-col { border-right: none; border-left: 2px solid #222; }
        .notes-col-title {
            font-size: 0.82rem;
            font-weight: 700;
            color: #555;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .notes-text { font-size: 0.9rem; color: #333; line-height: 1.5; }

        .totals-col { width: 290px; }
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 14px;
            border-bottom: 1px solid #ddd;
        }
        .total-row:last-child { border-bottom: none; }
        .total-label { font-size: 0.88rem; font-weight: 600; color: #444; }
        .total-value { font-size: 0.88rem; font-weight: 700; color: #222; }
        .remaining-row { background: #f0f7ff; }

        /* Footer */
        .invoice-footer {
            text-align: center;
            border-top: 2px solid #222;
            padding-top: 10px;
            margin-top: 16px;
            font-size: 0.82rem;
            color: #555;
        }

        /* ── Nav ── */
        .top-nav {
            background: #1565c0;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            height: 52px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-brand { font-size: 1.1rem; font-weight: 700; color: #fff; text-decoration: none; }
        .nav-links { display: flex; gap: 8px; align-items: center; }
        .nav-btn { padding: 6px 16px; border-radius: 4px; font-size: 0.88rem; font-weight: 600; cursor: pointer; text-decoration: none; border: none; }
        .nav-btn-outline { background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,0.6); }
        .nav-btn-outline:hover { background: rgba(255,255,255,0.12); }
        .nav-btn-solid { background: #fff; color: #1565c0; }
        .nav-btn-solid:hover { background: #e3f0ff; }
        .lang-btns { display: flex; gap: 6px; margin-left: 12px; }
        [dir="rtl"] .lang-btns { margin-left: 0; margin-right: 12px; }
        .lang-btn-nav { padding: 4px 10px; border-radius: 4px; background: rgba(255,255,255,0.15); color: #fff; border: none; cursor: pointer; font-size: 0.8rem; }
        .lang-btn-nav:hover { background: rgba(255,255,255,0.3); }

        /* Action Buttons */
        .action-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 14px;
        }
        .btn {
            padding: 9px 26px;
            font-size: 0.92rem;
            font-weight: 700;
            background: #1565c0;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover { background: #1e88e5; }
        .btn-secondary { background: #38a169; }
        .btn-secondary:hover { background: #2f855a; }

        /* ── Print ─────────────────────────────────────────────────── */
        @media print {
            .top-nav { display: none !important; }
            @page {
                size: A4 portrait;
                margin: 12mm 15mm;
            }

            body {
                background: #fff;
                padding: 0;
                display: block;
                min-height: auto;
            }

            .invoice-wrapper {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
                width: 100%;
            }

            .lang-switcher,
            .action-buttons { display: none !important; }

            /*
             * The outer wrapper becomes a CSS table.
             * .print-header → table-header-group  (repeats at top of every page)
             * .print-footer → table-footer-group  (repeats at bottom of every page)
             * .print-body   → table-row-group     (scrolls normally)
             */
            .print-outer {
                display: table;
                width: 100%;
                table-layout: fixed;
            }
            .print-header { display: table-header-group; }
            .print-footer { display: table-footer-group; }
            .print-body   { display: table-row-group; }
            .print-row    { display: table-row; }
            .print-cell   {
                display: table-cell;
                width: 100%;
            }
            /* Small gap below header block before items start */
            .print-header .print-cell { padding-bottom: 10px; }
            /* Small gap above footer */
            .print-footer .print-cell { padding-top: 10px; }
        }

        @media (max-width: 600px) {
            .info-grid { grid-template-columns: 1fr; }
            .info-block + .info-block { border-left: none; border-top: 2px solid #222; }
            .bottom-row { flex-direction: column; }
            .notes-col { border-right: none; border-bottom: 2px solid #222; }
            .totals-col { width: 100%; }
        }
    </style>
</head>

<body>
    <!-- Navigation (hidden in print) -->
    <nav class="top-nav">
        <a class="nav-brand" href="{{ route('invoice.create') }}">{{ setting('company_name', 'Beston Oil') }}</a>
        <div class="nav-links">
            <a href="{{ route('invoice.create') }}" class="nav-btn nav-btn-solid">+ {{ __('invoice.new_invoice') }}</a>
            <a href="{{ route('invoices.index') }}" class="nav-btn nav-btn-outline">{{ __('invoice.all_invoices') }}</a>
            <a href="{{ route('settings.edit') }}" class="nav-btn nav-btn-outline">⚙️ {{ __('invoice.settings') }}</a>
            @if(isset($invoice->id))
                <a href="{{ route('invoice.edit', $invoice->id) }}" class="nav-btn nav-btn-outline">✏️ {{ __('invoice.edit') }}</a>
            @endif
            <div class="lang-btns">
                <button class="lang-btn-nav" onclick="window.location='/change-language/en'">EN</button>
                <button class="lang-btn-nav" onclick="window.location='/change-language/ku'">KU</button>
                <button class="lang-btn-nav" onclick="window.location='/change-language/ar'">AR</button>
            </div>
        </div>
    </nav>

    <div class="invoice-wrapper">

        <!-- Language Selector (hidden in print) -->
        <form method="GET" id="langForm" class="lang-switcher">
            <label for="lang">{{ __('invoice.language') }}:</label>
            <select name="lang" id="lang"
                onchange="if(this.value) window.location.href='/change-language/' + this.value;">
                <option value="en" @if(app()->getLocale() == 'en') selected @endif>English</option>
                <option value="ku" @if(app()->getLocale() == 'ku') selected @endif>کوردی</option>
                <option value="ar" @if(app()->getLocale() == 'ar') selected @endif>العربية</option>
            </select>
        </form>

        <div class="print-outer">

            <!-- ═══ REPEATING HEADER (every page) ═══ -->
            <div class="print-header">
                <div class="print-row">
                    <div class="print-cell">

                        <!-- Company Header -->
                        <div class="invoice-header">
                            <div class="header-left">
                                <img src="{{ logo_url() }}" alt="Logo" class="company-logo">
                                <div class="company-name-text">{{ setting('company_name', 'Beston Oil') }}</div>
                            </div>
                            <div class="header-right">
                                @if(setting('company_info'))
                                <div style="font-size:0.88rem;font-weight:600;color:#222;margin-bottom:6px;padding-bottom:6px;border-bottom:1px solid #ddd;">
                                    {!! nl2br(e(setting('company_info'))) !!}
                                </div>
                                @endif
                                @if(setting('company_address'))
                                <div>
                                    <span style="font-size:0.72rem;color:#777;">Address / ناونیشان / العنوان:</span><br>
                                    {{ setting('company_address') }}
                                </div>
                                @endif
                                @if(setting('company_location'))
                                <div>
                                    <span style="font-size:0.72rem;color:#777;">Location / شوێن / الموقع:</span><br>
                                    📍 {{ setting('company_location') }}
                                </div>
                                @endif
                                @if(setting('company_phone'))
                                <div>
                                    <span style="font-size:0.72rem;color:#777;">Tel / تەلەفۆن / هاتف:</span><br>
                                    📞 {{ setting('company_phone') }}
                                </div>
                                @endif
                                <div>{{ __('invoice.currency') }}: {{ $invoice->currency }}</div>
                            </div>
                        </div>

                        <!-- Tax Invoice Title -->
                        <div class="invoice-title-bar">{{ __('invoice.tax_invoice') }}</div>

                        <!-- Info Grid: Invoice details | Client info -->
                        <div class="info-grid">
                            <div class="info-block">
                                <div class="info-row">
                                    <span class="info-label">{{ __('invoice.invoice_number') }}:</span>
                                    <span class="info-value">{{ $invoice->number }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">{{ __('invoice.date') }}:</span>
                                    <span class="info-value">{{ $invoice->date->format('Y-m-d') }}</span>
                                </div>
                            </div>
                            <div class="info-block">
                                <div class="info-block-title">{{ __('invoice.client') }}</div>
                                <div class="info-row">
                                    <span class="info-label">{{ __('invoice.customer_name') }}:</span>
                                    <span class="info-value">{{ $invoice->customer_name }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">{{ __('invoice.address') }}:</span>
                                    <span class="info-value">{{ $invoice->address }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">{{ __('invoice.phone') }}:</span>
                                    <span class="info-value">{{ $invoice->phone }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- ═══ END REPEATING HEADER ═══ -->

            <!-- ═══ REPEATING FOOTER (every page) ═══ -->
            <div class="print-footer">
                <div class="print-row">
                    <div class="print-cell">
                        <div class="invoice-footer">
                            <strong>{{ setting('company_name', 'Beston Oil') }}</strong>
                            @if(setting('company_address')) &nbsp;|&nbsp; {{ setting('company_address') }} @endif
                            @if(setting('company_location')) &nbsp;|&nbsp; 📍 {{ setting('company_location') }} @endif
                            @if(setting('company_phone')) &nbsp;|&nbsp; 📞 {{ setting('company_phone') }} @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- ═══ END REPEATING FOOTER ═══ -->

            <!-- ═══ PAGE BODY ═══ -->
            <div class="print-body">
                <div class="print-row">
                    <div class="print-cell">

                        <!-- Items Table (its own <thead> also repeats if items span pages) -->
                        @php
                            $subtotal = 0;
                            $sym = __('invoice.' . $invoice->currency);
                        @endphp
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>{{ __('invoice.item_name') }}</th>
                                    <th>{{ __('invoice.unit_type') }}</th>
                                    <th>{{ __('invoice.quantity') }}</th>
                                    <th>{{ __('invoice.unit_price') }}</th>
                                    <th>{{ __('invoice.total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->items as $item)
                                    @php
                                        $item_total = $item->quantity * $item->unit_price;
                                        $subtotal += $item_total;
                                        $unitLabel = __('invoice.unit_' . ($item->unit_type ?: 'single'));
                                        if ($item->unit_detail) {
                                            if ($item->unit_type === 'box')    $unitLabel .= ' (' . $item->unit_detail . ' ' . __('invoice.pieces') . ')';
                                            if ($item->unit_type === 'bottle') $unitLabel .= ' (' . $item->unit_detail . 'L)';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $unitLabel }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $sym }}{{ number_format($item->unit_price, 2) }}</td>
                                        <td>{{ $sym }}{{ number_format($item_total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Notes + Totals -->
                        @php
                            $tax        = $invoice->tax  ?? 0;
                            $paid       = $invoice->paid ?? 0;
                            $grandTotal = $subtotal + $tax;
                            $remaining  = $grandTotal - $paid;
                        @endphp
                        <div class="bottom-row">
                            <div class="notes-col">
                                <div class="notes-col-title">{{ __('invoice.notes') }}</div>
                                @if(!empty($invoice->notes))
                                    <div class="notes-text">{{ $invoice->notes }}</div>
                                @endif
                            </div>
                            <div class="totals-col">
                                <div class="total-row">
                                    <span class="total-label">{{ __('invoice.subtotal') }}</span>
                                    <span class="total-value">{{ $sym }}{{ number_format($subtotal, 2) }}</span>
                                </div>
                                @if($tax > 0)
                                <div class="total-row">
                                    <span class="total-label">{{ __('invoice.tax') }}</span>
                                    <span class="total-value">{{ $sym }}{{ number_format($tax, 2) }}</span>
                                </div>
                                @endif
                                <div class="total-row">
                                    <span class="total-label">{{ __('invoice.paid') }}</span>
                                    <span class="total-value">{{ $sym }}{{ number_format($paid, 2) }}</span>
                                </div>
                                <div class="total-row remaining-row">
                                    <span class="total-label">{{ __('invoice.remaining') }}</span>
                                    <span class="total-value">{{ $sym }}{{ number_format($remaining, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Screen-only action buttons -->
                        <div class="action-buttons">
                            <button class="btn" onclick="window.print()">🖨️ {{ __('invoice.print') }}</button>
                            @if(isset($invoice->id))
                                <a href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-secondary">✏️ {{ __('invoice.edit') }}</a>
                            @endif
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">📋 {{ __('invoice.all_invoices') }}</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- ═══ END PAGE BODY ═══ -->

        </div><!-- /.print-outer -->
    </div><!-- /.invoice-wrapper -->

    @if(session('print_now'))
    <script>window.addEventListener('load', () => setTimeout(() => window.print(), 400));</script>
    @endif
</body>

</html>
