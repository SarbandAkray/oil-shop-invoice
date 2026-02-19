<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ku', 'ar']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('invoice.all_invoices') }} — Beston Oil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #d0d0d0;
            min-height: 100vh;
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
        .nav-btn {
            padding: 6px 16px;
            border-radius: 4px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }
        .nav-btn-outline { background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,0.6); }
        .nav-btn-outline:hover { background: rgba(255,255,255,0.12); }
        .nav-btn-solid { background: #fff; color: #1565c0; }
        .nav-btn-solid:hover { background: #e3f0ff; }
        .lang-btns { display: flex; gap: 6px; margin-left: 12px; }
        [dir="rtl"] .lang-btns { margin-left: 0; margin-right: 12px; }
        .lang-btn { padding: 4px 10px; border-radius: 4px; background: rgba(255,255,255,0.15); color: #fff; border: none; cursor: pointer; font-size: 0.8rem; }
        .lang-btn:hover { background: rgba(255,255,255,0.3); }

        /* ── Page wrapper ── */
        .page-wrapper {
            max-width: 1050px;
            margin: 28px auto;
            padding: 0 16px;
        }

        /* ── Search bar ── */
        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
        }
        .search-bar input {
            flex: 1;
            padding: 9px 14px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 0.95rem;
            font-family: inherit;
        }
        .search-bar input:focus { outline: none; border-color: #1565c0; }
        .search-bar button {
            padding: 9px 22px;
            background: #1565c0;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 0.92rem;
            font-weight: 600;
            cursor: pointer;
        }
        .search-bar button:hover { background: #1976d2; }
        .search-bar a {
            padding: 9px 16px;
            background: #555;
            color: #fff;
            border-radius: 5px;
            font-size: 0.88rem;
            text-decoration: none;
        }
        .search-bar a:hover { background: #333; }

        /* ── Flash message ── */
        .flash {
            padding: 10px 16px;
            border-radius: 5px;
            margin-bottom: 14px;
            font-size: 0.92rem;
            font-weight: 600;
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        /* ── Table card ── */
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.12);
            overflow: hidden;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-header h2 { font-size: 1.1rem; font-weight: 700; color: #222; }
        .badge {
            background: #e3f0ff;
            color: #1565c0;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead th {
            background: #1565c0;
            color: #fff;
            padding: 11px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            text-align: left;
            white-space: nowrap;
        }
        [dir="rtl"] thead th { text-align: right; }
        tbody td {
            padding: 11px 14px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9rem;
            color: #333;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #f5f9ff; }

        .text-muted { color: #888; font-size: 0.82rem; }
        .amount { font-weight: 700; color: #1565c0; }

        /* Status badges */
        .status-paid { color: #065f46; background: #d1fae5; padding: 2px 8px; border-radius: 12px; font-size: 0.78rem; font-weight: 700; }
        .status-partial { color: #92400e; background: #fef3c7; padding: 2px 8px; border-radius: 12px; font-size: 0.78rem; font-weight: 700; }
        .status-unpaid { color: #991b1b; background: #fee2e2; padding: 2px 8px; border-radius: 12px; font-size: 0.78rem; font-weight: 700; }

        /* Action buttons */
        .action-btns { display: flex; gap: 6px; flex-wrap: nowrap; }
        .btn-view { padding: 5px 12px; background: #1565c0; color: #fff; border-radius: 4px; text-decoration: none; font-size: 0.8rem; font-weight: 600; white-space: nowrap; }
        .btn-view:hover { background: #1976d2; }
        .btn-edit { padding: 5px 12px; background: #f59e0b; color: #fff; border-radius: 4px; text-decoration: none; font-size: 0.8rem; font-weight: 600; white-space: nowrap; }
        .btn-edit:hover { background: #d97706; }
        .btn-del { padding: 5px 12px; background: #dc2626; color: #fff; border-radius: 4px; border: none; font-size: 0.8rem; font-weight: 600; cursor: pointer; white-space: nowrap; }
        .btn-del:hover { background: #b91c1c; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #888;
        }
        .empty-state .icon { font-size: 3rem; margin-bottom: 12px; }
        .empty-state p { font-size: 1rem; margin-bottom: 16px; }

        /* Pagination */
        .pagination { margin-top: 20px; display: flex; justify-content: center; gap: 6px; flex-wrap: wrap; }
        .pagination a, .pagination span {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.88rem;
            text-decoration: none;
            background: #fff;
            color: #1565c0;
            border: 1px solid #cbd5e1;
        }
        .pagination .active { background: #1565c0; color: #fff; border-color: #1565c0; }
        .pagination a:hover { background: #e3f0ff; }
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
            <div class="lang-btns">
                <button class="lang-btn" onclick="window.location='/change-language/en'">EN</button>
                <button class="lang-btn" onclick="window.location='/change-language/ku'">KU</button>
                <button class="lang-btn" onclick="window.location='/change-language/ar'">AR</button>
            </div>
        </div>
    </nav>

    <div class="page-wrapper">

        @if(session('success'))
            <div class="flash">✓ {{ session('success') }}</div>
        @endif

        <!-- Search -->
        <form method="GET" action="{{ route('invoices.index') }}" class="search-bar">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="{{ __('invoice.search_placeholder') }}">
            <button type="submit">🔍</button>
            @if($search)
                <a href="{{ route('invoices.index') }}">✕</a>
            @endif
        </form>

        <!-- Table card -->
        <div class="card">
            <div class="card-header">
                <h2>{{ __('invoice.all_invoices') }}</h2>
                <span class="badge">{{ $invoices->total() }}</span>
            </div>

            @if($invoices->isEmpty())
                <div class="empty-state">
                    <div class="icon">🧾</div>
                    <p>{{ __('invoice.no_invoices') }}</p>
                    <a href="{{ route('invoice.create') }}" class="btn-view">+ {{ __('invoice.new_invoice') }}</a>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('invoice.invoice_number') }}</th>
                            <th>{{ __('invoice.date') }}</th>
                            <th>{{ __('invoice.customer_name') }}</th>
                            <th>{{ __('invoice.phone') }}</th>
                            <th>{{ __('invoice.total') }}</th>
                            <th>{{ __('invoice.remaining') }}</th>
                            <th>{{ __('invoice.actions_col') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $inv)
                            @php
                                $subtotal = $inv->items->sum(fn($i) => $i->quantity * $i->unit_price);
                                $total    = $subtotal + $inv->tax;
                                $remaining= $total - $inv->paid;
                                $sym      = __('invoice.' . $inv->currency);
                                if ($remaining <= 0) $statusClass = 'status-paid';
                                elseif ($inv->paid > 0) $statusClass = 'status-partial';
                                else $statusClass = 'status-unpaid';
                            @endphp
                            <tr>
                                <td class="text-muted">{{ $loop->iteration + ($invoices->currentPage()-1) * $invoices->perPage() }}</td>
                                <td><strong>{{ $inv->number }}</strong></td>
                                <td>{{ $inv->date->format('Y-m-d') }}</td>
                                <td>{{ $inv->customer_name ?: '—' }}</td>
                                <td>{{ $inv->phone ?: '—' }}</td>
                                <td class="amount">{{ $sym }}{{ number_format($total, 2) }}</td>
                                <td>
                                    <span class="{{ $statusClass }}">{{ $sym }}{{ number_format($remaining, 2) }}</span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('invoice.show', $inv->id) }}" class="btn-view">🖨️ {{ __('invoice.print') }}</a>
                                        <a href="{{ route('invoice.edit', $inv->id) }}" class="btn-edit">✏️ {{ __('invoice.edit') }}</a>
                                        <form method="POST" action="{{ route('invoice.destroy', $inv->id) }}"
                                              onsubmit="return confirm('{{ __('invoice.confirm_delete') }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-del">🗑️ {{ __('invoice.delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($invoices->hasPages())
                    <div class="pagination">
                        {{-- Previous --}}
                        @if($invoices->onFirstPage())
                            <span style="opacity:0.4;">‹ Prev</span>
                        @else
                            <a href="{{ $invoices->previousPageUrl() }}">‹ Prev</a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach($invoices->getUrlRange(1, $invoices->lastPage()) as $page => $url)
                            @if($page == $invoices->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if($invoices->hasMorePages())
                            <a href="{{ $invoices->nextPageUrl() }}">Next ›</a>
                        @else
                            <span style="opacity:0.4;">Next ›</span>
                        @endif
                    </div>
                @endif
            @endif
        </div>

    </div>
</body>
</html>
