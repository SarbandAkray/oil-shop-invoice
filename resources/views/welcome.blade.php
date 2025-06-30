<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ku', 'ar']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('invoice.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Import Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        /* General Body Styling */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            color: #1a202c;
            min-height: 100vh;
            margin: 0;
            padding: 20px 0;
        }

        .invoice-container {
            background-color: #ffffff;
            padding: 40px;
            margin: 20px auto;
            border-radius: 16px;
            max-width: 900px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
        }

        .invoice-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        /* Print Specific Styles */
        @media print {
            body {
                margin: 30;
                background: #ffffff;
                padding: 0;
            }

            .invoice-container {
                margin: 0;
                padding: 15mm;
                width: 210mm;
                height: 297mm;
                font-size: 12px;
                box-shadow: none;
                border-radius: 0;
            }

            .invoice-container::before {
                display: none;
            }

            .hide-on-print {
                display: none !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table th,
            table td {
                border: 1px solid #e2e8f0;
                padding: 8px;
                text-align: left;
            }

            @page {
                size: A4;
                margin: 10mm;
            }
        }

        /* Language Picker */
        .language-picker {
            margin-bottom: 30px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
        }

        .language-picker span {
            font-weight: 500;
            color: #4a5568;
            font-size: 14px;
        }

        .language-btn {
            padding: 8px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 20px;
            color: white;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .language-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Header Section */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f7fafc;
        }

        .company-info {
            display: flex;
            flex-direction: column;
        }

        .company-info img {
            height: 150px;
            margin-bottom: 8px;
        }

        .company-info h1 {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 32px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input {
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #ffffff;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input[readonly] {
            background-color: #f7fafc;
            color: #4a5568;
            font-weight: 500;
        }

        /* Table Styling */
        .table-container {
            margin: 32px 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        table th {
            padding: 16px 12px;
            color: white;
            font-weight: 600;
            text-align: left;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        table td input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        table td input:focus {
            outline: none;
            border-color: #667eea;
        }

        table td:last-child {
            font-weight: 600;
            color: #2d3748;
            background-color: #f8fafc;
        }

        /* Summary Section */
        .summary-section {
            margin-top: 40px;
            padding: 24px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .summary-item {
            display: flex;
            flex-direction: column;
        }

        .summary-item label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-item input {
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .summary-item input[readonly] {
            background-color: #ffffff;
            font-weight: 600;
            color: #2d3748;
        }

        .summary-item:last-child input {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 700;
            font-size: 18px;
        }

        /* Buttons */
        .btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        }

        .btn-secondary:hover {
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
        }

        /* Action Buttons Container */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 40px;
            padding-top: 24px;
            border-top: 2px solid #f7fafc;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .invoice-container {
                margin: 10px;
                padding: 24px;
            }

            .invoice-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .invoice-title {
                font-size: 24px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            table {
                font-size: 14px;
            }

            table th,
            table td {
                padding: 8px 6px;
            }
        }

        /* Loading and Animation Effects */
        .form-group input,
        .btn,
        table td input {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Add subtle animations */
        .invoice-container {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <form method="POST" action="{{ route('invoice.store') }}">
        @csrf
        <div class="invoice-container">
            <!-- Language Picker -->
            <div class="language-picker hide-on-print">
                <span>Language:</span>
                <button class="language-btn" type="button" onclick="changeLanguage('en')">English</button>
                <button class="language-btn" type="button" onclick="changeLanguage('ku')">Kurdish</button>
                <button class="language-btn" type="button" onclick="changeLanguage('ar')">Arabic</button>
            </div>

            <!-- Invoice Header Section -->
            <div class="invoice-header">
                <div class="company-info">
                    <img src="/logo.png" alt="Company Logo">
                    <h1>Beston</h1>
                </div>
                <h2 class="invoice-title">{{ __('invoice.title') }}</h2>
            </div>

            <!-- Invoice and Date Section -->
            <div class="form-section">
                <div class="form-grid">
                    <div class="form-group">
                        <label>{{ __('invoice.invoice_number') }}</label>
                        <input type="text" id="invoice_number" name="number" required readonly>
                    </div>
                    <div class="form-group">
                        <label>{{ __('invoice.date') }}</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                </div>
            </div>

            <!-- Customer Details Section -->
            <div class="form-section">
                <div class="form-grid">
                    <div class="form-group">
                        <label>{{ __('invoice.customer_name') }}</label>
                        <input type="text" name="customer_name" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('invoice.address') }}</label>
                        <input type="text" name="address" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('invoice.phone') }}</label>
                        <input type="tel" name="phone" required>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-container">
                <table id="items-table">
                    <thead>
                        <tr>
                            <th>{{ __('invoice.item_name') }}</th>
                            <th>{{ __('invoice.quantity') }}</th>
                            <th>{{ __('invoice.unit_price') }}</th>
                            <th>{{ __('invoice.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="items[0][name]" required></td>
                            <td><input type="number" min="1" value="1" name="items[0][quantity]"
                                    onchange="updateTotal(this)" required></td>
                            <td><input type="number" min="0" step="0.01" value="0"
                                    name="items[0][unit_price]" onchange="updateTotal(this)" required></td>
                            <td>$0.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <button class="btn btn-secondary hide-on-print" type="button" onclick="addRow()">
                    <span>+</span>
                    {{ __('invoice.add_item') }}
                </button>
            </div>

            <!-- Summary Section -->
            <div class="summary-section">
                <div class="summary-grid">
                    <div class="summary-item">
                        <label>{{ __('invoice.subtotal') }}</label>
                        <input type="text" id="subtotal" readonly>
                    </div>
                    <div class="summary-item">
                        <label>{{ __('invoice.tax') }}</label>
                        <input type="number" id="tax" name="tax" min="0" step="0.01"
                            onchange="updateGrandTotal()">
                    </div>
                    <div class="summary-item">
                        <label>{{ __('invoice.grand_total') }}</label>
                        <input type="text" id="grand_total" readonly>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons hide-on-print">
                <button class="btn" type="submit">
                    <span>🖨</span>
                    {{ __('invoice.print') }}
                </button>
            </div>
        </div>
    </form>
    <script>
        // Handle automatic date and invoice number.
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('date').value = new Date().toISOString().split('T')[0];
            document.getElementById('invoice_number').value = 'INV-' + Math.floor(Math.random() * 100000).toString()
                .padStart(5, '0');
        });

        function updateTotal(input) {
            const row = input.closest('tr');
            const quantity = parseFloat(row.querySelector('input[name$="[quantity]"]').value) || 0;
            const price = parseFloat(row.querySelector('input[name$="[unit_price]"]').value) || 0;
            const totalCell = row.querySelector('td:last-child');
            const total = quantity * price;
            totalCell.textContent = `$${total.toFixed(2)}`;
            updateSubtotal();
        }

        function updateSubtotal() {
            let subtotal = 0;
            document.querySelectorAll('#items-table tbody tr').forEach(row => {
                subtotal += parseFloat(row.querySelector('td:last-child').textContent.replace('$', '')) || 0;
            });
            document.getElementById('subtotal').value = `$${subtotal.toFixed(2)}`;
            updateGrandTotal();
        }

        function updateGrandTotal() {
            const subtotal = parseFloat(document.getElementById('subtotal').value.replace('$', '')) || 0;
            const tax = parseFloat(document.getElementById('tax').value) || 0;
            const grandTotal = subtotal + tax;
            document.getElementById('grand_total').value = `$${grandTotal.toFixed(2)}`;
        }

        function addRow() {
            const table = document.querySelector('#items-table tbody');
            const rowCount = table.rows.length;
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="items[${rowCount}][name]" required></td>
                <td><input type="number" min="1" value="1" name="items[${rowCount}][quantity]" onchange="updateTotal(this)" required></td>
                <td><input type="number" min="0" step="0.01" value="0" name="items[${rowCount}][unit_price]" onchange="updateTotal(this)" required></td>
                <td>$0.00</td>
            `;
            table.appendChild(newRow);
        }

        function changeLanguage(lang) {
            window.location.href = '/change-language/' + lang;
        }
    </script>
</body>

</html>
