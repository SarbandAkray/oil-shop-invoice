<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ku', 'ar']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('invoice.tax_invoice') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #d0d0d0;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #222;
            min-height: 100vh;
            padding: 0;
        }

        .invoice-wrapper {
            background: #fff;
            max-width: 900px;
            margin: 28px auto;
            padding: 28px 32px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.18);
        }

        /* Language Picker */
        .language-picker {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-bottom: 14px;
            align-items: center;
        }
        [dir="rtl"] .language-picker { justify-content: flex-start; }
        .lang-btn {
            padding: 5px 14px;
            background: #222;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .lang-btn:hover { background: #555; }

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
        .header-right div { margin-bottom: 5px; }

        /* Tax Invoice Title */
        .invoice-title-bar {
            text-align: center;
            font-size: 1.75rem;
            font-weight: 700;
            color: #222;
            border-top: 2px solid #222;
            border-bottom: 2px solid #222;
            padding: 9px 0;
            margin: 0 0 14px 0;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border: 1px solid #999;
            margin-bottom: 0;
            direction: ltr;
        }
        .info-block { padding: 12px; direction: inherit; }
        .info-block + .info-block { border-left: 1px solid #999; }
        [dir="rtl"] .info-block { direction: rtl; }

        .info-block-title {
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
            color: #222;
        }
        .form-row { display: flex; flex-direction: column; margin-bottom: 9px; }
        .form-row:last-child { margin-bottom: 0; }
        .form-row label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .form-row input,
        .form-row select {
            padding: 7px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 0.92rem;
            width: 100%;
            font-family: inherit;
        }
        .form-row input:focus,
        .form-row select:focus { outline: none; border-color: #555; }
        .form-row input[readonly] { background: #f5f5f5; color: #555; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #222;
            border-top: none;
        }
        thead { border-top: 2px solid #222; }
        th {
            background: #1565c0;
            color: #ffd600;
            padding: 10px 12px;
            font-size: 0.85rem;
            text-align: left;
            border: 2px solid #1565c0;
            font-weight: 700;
        }
        [dir="rtl"] th { text-align: right; }
        td {
            padding: 7px 10px;
            border: 2px solid #555;
            vertical-align: middle;
        }
        td input {
            width: 100%;
            padding: 6px 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 0.9rem;
            font-family: inherit;
        }
        td input:focus { outline: none; border-color: #888; }

        /* Add item row */
        .add-item-row {
            text-align: center;
            padding: 8px;
            border: 1px solid #999;
            border-top: none;
        }
        .btn-add {
            background: #333;
            color: #fff;
            border: none;
            padding: 7px 20px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 0.88rem;
            font-weight: 600;
        }
        .btn-add:hover { background: #555; }

        .btn-delete {
            background: #dc2626;
            color: #fff;
            border: none;
            padding: 5px 11px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 0.85rem;
        }
        .btn-delete:hover { background: #b91c1c; }

        /* Bottom row: Notes + Totals */
        .bottom-row {
            display: flex;
            border: 1px solid #999;
            border-top: none;
        }
        .notes-col {
            flex: 1;
            padding: 12px;
            border-right: 1px solid #999;
        }
        [dir="rtl"] .notes-col { border-right: none; border-left: 1px solid #999; }
        .notes-col label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .notes-col textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 7px;
            font-size: 0.9rem;
            resize: vertical;
            min-height: 90px;
            font-family: inherit;
            color: #333;
        }
        .notes-col textarea:focus { outline: none; border-color: #888; }

        .totals-col { width: 290px; }
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 14px;
            border-bottom: 1px solid #eee;
        }
        .total-row:last-child { border-bottom: none; }
        .total-label { font-size: 0.88rem; font-weight: 600; color: #444; }
        .total-value { font-size: 0.88rem; font-weight: 700; color: #222; }
        .total-input {
            width: 110px;
            padding: 5px 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 0.88rem;
            text-align: right;
            font-family: inherit;
        }
        [dir="rtl"] .total-input { text-align: left; }
        .total-input:focus { outline: none; border-color: #888; }
        .remaining-row { background: #f5f5f5; }

        /* Action buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 20px;
            padding-top: 14px;
            border-top: 1px solid #ddd;
        }
        .btn-submit {
            background: #222;
            color: #fff;
            border: none;
            padding: 10px 32px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 700;
        }
        .btn-submit:hover { background: #444; }

        /* ── Nav ── */
        .top-nav {
            background: #1565c0;
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
        .lang-btns-nav { display: flex; gap: 6px; margin-left: 12px; }
        [dir="rtl"] .lang-btns-nav { margin-left: 0; margin-right: 12px; }
        .lang-btn-nav { padding: 4px 10px; border-radius: 4px; background: rgba(255,255,255,0.15); color: #fff; border: none; cursor: pointer; font-size: 0.8rem; }
        .lang-btn-nav:hover { background: rgba(255,255,255,0.3); }

        @media print {
            body { background: #fff; padding: 0; }
            .top-nav { display: none !important; }
            .invoice-wrapper { box-shadow: none; padding: 0; }
            .language-picker, .action-buttons, .btn-add, .btn-delete, .add-item-row { display: none !important; }
        }

        @media (max-width: 600px) {
            .info-grid { grid-template-columns: 1fr; }
            .info-block + .info-block { border-left: none; border-top: 1px solid #999; }
            .bottom-row { flex-direction: column; }
            .notes-col { border-right: none; border-bottom: 1px solid #999; }
            .totals-col { width: 100%; }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="top-nav">
        <a class="nav-brand" href="{{ route('invoice.create') }}">{{ setting('company_name', 'Beston Oil') }}</a>
        <div class="nav-links">
            <a href="{{ route('invoice.create') }}" class="nav-btn nav-btn-solid">+ {{ __('invoice.new_invoice') }}</a>
            <a href="{{ route('invoices.index') }}" class="nav-btn nav-btn-outline">{{ __('invoice.all_invoices') }}</a>
            <a href="{{ route('settings.edit') }}" class="nav-btn nav-btn-outline">⚙️ {{ __('invoice.settings') }}</a>
            <div class="lang-btns-nav">
                <button class="lang-btn-nav" onclick="window.location='/change-language/en'">EN</button>
                <button class="lang-btn-nav" onclick="window.location='/change-language/ku'">KU</button>
                <button class="lang-btn-nav" onclick="window.location='/change-language/ar'">AR</button>
            </div>
        </div>
    </nav>

    <form method="POST" action="{{ route('invoice.store') }}">
        @csrf
        <div class="invoice-wrapper">

            <!-- Header: Logo left, company info right -->
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
                </div>
            </div>

            <!-- Tax Invoice Title -->
            <div class="invoice-title-bar">{{ __('invoice.tax_invoice') }}</div>

            <!-- Info Grid: Invoice details (left) | Client info (right) -->
            <div class="info-grid">
                <div class="info-block">
                    <div class="form-row">
                        <label>{{ __('invoice.currency') }}</label>
                        <select id="currency" name="currency" onchange="updateCurrencySymbol()">
                            <option value="IQD" @selected(setting('default_currency','IQD')==='IQD')>IQD (د.ع)</option>
                            <option value="USD" @selected(setting('default_currency','IQD')==='USD')>USD ($)</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label>{{ __('invoice.invoice_number') }}</label>
                        <input type="text" id="invoice_number" name="number" readonly required>
                    </div>
                    <div class="form-row">
                        <label>{{ __('invoice.date') }}</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                </div>
                <div class="info-block">
                    <div class="info-block-title">{{ __('invoice.client') }}</div>
                    <div class="form-row">
                        <label>{{ __('invoice.customer_name') }}</label>
                        <input type="text" name="customer_name">
                    </div>
                    <div class="form-row">
                        <label>{{ __('invoice.address') }}</label>
                        <input type="text" name="address">
                    </div>
                    <div class="form-row">
                        <label>{{ __('invoice.phone') }}</label>
                        <input type="tel" name="phone">
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <table id="items-table">
                <thead>
                    <tr>
                        <th>{{ __('invoice.item_name') }}</th>
                        <th>{{ __('invoice.unit_type') }}</th>
                        <th>{{ __('invoice.quantity') }}</th>
                        <th>{{ __('invoice.unit_price') }}</th>
                        <th>{{ __('invoice.total') }}</th>
                        <th>{{ __('invoice.actions') }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <!-- Add item -->
            <div class="add-item-row">
                <button class="btn-add" type="button" onclick="addRow()">+ {{ __('invoice.add_item') }}</button>
            </div>

            <!-- Bottom: Notes + Totals -->
            <div class="bottom-row">
                <div class="notes-col">
                    <label>{{ __('invoice.notes') }}</label>
                    <textarea name="notes" placeholder="{{ __('invoice.notes') }}..."></textarea>
                </div>
                <div class="totals-col">
                    <div class="total-row">
                        <span class="total-label">{{ __('invoice.subtotal') }}</span>
                        <span class="total-value" id="subtotal-display">--</span>
                        <input type="hidden" id="subtotal-hidden">
                    </div>
                    <div class="total-row">
                        <span class="total-label">{{ __('invoice.tax') }}</span>
                        <input class="total-input" type="number" id="tax" name="tax" min="0" step="0.01" value="0" onchange="recalculate()">
                    </div>
                    <div class="total-row">
                        <span class="total-label">{{ __('invoice.paid') }}</span>
                        <input class="total-input" type="number" id="paid" name="paid" min="0" step="0.01" value="0" onchange="recalculate()">
                    </div>
                    <div class="total-row remaining-row">
                        <span class="total-label">{{ __('invoice.remaining') }}</span>
                        <span class="total-value" id="remaining-display">--</span>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="action-buttons">
                <button class="btn-submit" type="submit">🖨️ {{ __('invoice.print') }}</button>
            </div>

        </div>
    </form>

    <script>
        let invoiceItems = [];
        let currentCurrency = '{{ setting('default_currency', 'IQD') }}';

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('date').value = new Date().toISOString().split('T')[0];
            document.getElementById('invoice_number').value =
                'INV-' + Math.floor(Math.random() * 100000).toString().padStart(5, '0');

            const currencyEl = document.getElementById('currency');
            currentCurrency = currencyEl.value;
            currencyEl.addEventListener('change', (e) => {
                currentCurrency = e.target.value;
                render();
            });

            addRow();
        });

        function sym() {
            return currentCurrency === 'IQD' ? 'د.ع ' : '$';
        }

        function fmt(v) {
            v = parseFloat(v) || 0;
            return v % 1 !== 0 ? v.toFixed(2) : v.toLocaleString();
        }

        function escHtml(s) {
            const d = document.createElement('div');
            d.appendChild(document.createTextNode(s));
            return d.innerHTML;
        }

        function unitDetailLabel(type) {
            if (type === 'box')    return '{{ __("invoice.pieces_per_box") }}';
            if (type === 'bottle') return '{{ __("invoice.litres_per_bottle") }}';
            return '';
        }

        function render() {
            const tbody = document.querySelector('#items-table tbody');
            tbody.innerHTML = '';
            let subtotal = 0;

            invoiceItems.forEach((item, i) => {
                const total = (parseFloat(item.quantity) || 0) * (parseFloat(item.unit_price) || 0);
                subtotal += total;
                const needsDetail = item.unit_type === 'box' || item.unit_type === 'bottle';
                const detailLabel = unitDetailLabel(item.unit_type);
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="text" name="items[${i}][name]" value="${escHtml(item.name)}"
                        onchange="invoiceItems[${i}].name=this.value" required></td>
                    <td style="min-width:160px;">
                        <select name="items[${i}][unit_type]" onchange="invoiceItems[${i}].unit_type=this.value;invoiceItems[${i}].unit_detail='';render()"
                            style="width:100%;padding:5px 6px;border:1px solid #ddd;border-radius:3px;font-size:0.88rem;font-family:inherit;margin-bottom:${needsDetail?'4px':'0'}">
                            <option value="single"  ${item.unit_type==='single'  ?'selected':''}>{{ __('invoice.unit_single') }}</option>
                            <option value="box"     ${item.unit_type==='box'     ?'selected':''}>{{ __('invoice.unit_box') }}</option>
                            <option value="bottle"  ${item.unit_type==='bottle'  ?'selected':''}>{{ __('invoice.unit_bottle') }}</option>
                            <option value="kg"      ${item.unit_type==='kg'      ?'selected':''}>{{ __('invoice.unit_kg') }}</option>
                            <option value="liter"   ${item.unit_type==='liter'   ?'selected':''}>{{ __('invoice.unit_liter') }}</option>
                            <option value="other"   ${item.unit_type==='other'   ?'selected':''}>{{ __('invoice.unit_other') }}</option>
                        </select>
                        ${needsDetail ? `<input type="text" name="items[${i}][unit_detail]" value="${escHtml(item.unit_detail||'')}"
                            placeholder="${detailLabel}"
                            onchange="invoiceItems[${i}].unit_detail=this.value"
                            style="width:100%;padding:4px 6px;border:1px solid #ddd;border-radius:3px;font-size:0.82rem;font-family:inherit;">` : `<input type="hidden" name="items[${i}][unit_detail]" value="">`}
                    </td>
                    <td><input type="number" min="1" name="items[${i}][quantity]" value="${item.quantity}"
                        onchange="invoiceItems[${i}].quantity=parseFloat(this.value)||0;render()" required></td>
                    <td><input type="number" min="0" step="0.01" name="items[${i}][unit_price]" value="${item.unit_price}"
                        onchange="invoiceItems[${i}].unit_price=parseFloat(this.value)||0;render()" required></td>
                    <td>${sym()}${fmt(total)}</td>
                    <td><button type="button" class="btn-delete" onclick="deleteRow(${i})">🗑️</button></td>
                `;
                tbody.appendChild(row);
            });

            document.getElementById('subtotal-hidden').value = subtotal;
            document.getElementById('subtotal-display').textContent = sym() + fmt(subtotal);
            recalculate(subtotal);
        }

        function recalculate(subtotal) {
            if (subtotal === undefined) {
                subtotal = parseFloat(document.getElementById('subtotal-hidden').value) || 0;
            }
            const tax = parseFloat(document.getElementById('tax').value) || 0;
            const paid = parseFloat(document.getElementById('paid').value) || 0;
            document.getElementById('remaining-display').textContent = sym() + fmt((subtotal + tax) - paid);
        }

        function addRow() {
            invoiceItems.push({ name: '', quantity: 1, unit_price: 0, unit_type: 'single', unit_detail: '' });
            render();
        }

        function deleteRow(i) {
            invoiceItems.splice(i, 1);
            if (invoiceItems.length === 0) addRow();
            else render();
        }

        function updateCurrencySymbol() {
            currentCurrency = document.getElementById('currency').value;
            render();
        }

        function changeLanguage(lang) {
            window.location.href = '/change-language/' + lang;
        }
    </script>
</body>

</html>
