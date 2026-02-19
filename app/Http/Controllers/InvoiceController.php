<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /** Create form (new invoice) */
    public function create()
    {
        return view('welcome');
    }

    /** Save new invoice to DB */
    public function store(Request $request)
    {
        $data = $request->validate([
            'number'            => 'required|string|unique:invoices,number',
            'date'              => 'required|date',
            'customer_name'     => 'nullable|string',
            'address'           => 'nullable|string',
            'phone'             => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.name'        => 'required|string',
            'items.*.quantity'    => 'required|numeric|min:0',
            'items.*.unit_price'  => 'required|numeric|min:0',
            'items.*.unit_type'   => 'nullable|string',
            'items.*.unit_detail' => 'nullable|string',
            'tax'                 => 'nullable|numeric|min:0',
            'paid'                => 'nullable|numeric|min:0',
            'notes'               => 'nullable|string',
            'currency'            => 'nullable|string',
        ]);

        $invoice = Invoice::create([
            'number'        => $data['number'],
            'date'          => $data['date'],
            'customer_name' => $data['customer_name'] ?? null,
            'address'       => $data['address'] ?? null,
            'phone'         => $data['phone'] ?? null,
            'tax'           => $data['tax'] ?? 0,
            'paid'          => $data['paid'] ?? 0,
            'notes'         => $data['notes'] ?? null,
            'currency'      => $data['currency'] ?? 'IQD',
        ]);

        foreach ($data['items'] as $item) {
            $invoice->items()->create([
                'name'        => $item['name'],
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['unit_price'],
                'unit_type'   => $item['unit_type']   ?? 'single',
                'unit_detail' => $item['unit_detail']  ?? null,
            ]);
        }

        return redirect()->route('invoice.show', $invoice->id)
                         ->with('print_now', true);
    }

    /** List / search all invoices */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $invoices = Invoice::with('items')
            ->when($search, function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('date', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('invoices.index', compact('invoices', 'search'));
    }

    /** Print / view a single invoice */
    public function show(int $id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        return view('invoice', compact('invoice'));
    }

    /** Edit form */
    public function edit(int $id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }

    /** Update invoice in DB */
    public function update(Request $request, int $id)
    {
        $invoice = Invoice::findOrFail($id);

        $data = $request->validate([
            'number'            => "required|string|unique:invoices,number,{$id}",
            'date'              => 'required|date',
            'customer_name'     => 'nullable|string',
            'address'           => 'nullable|string',
            'phone'             => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.name'        => 'required|string',
            'items.*.quantity'    => 'required|numeric|min:0',
            'items.*.unit_price'  => 'required|numeric|min:0',
            'items.*.unit_type'   => 'nullable|string',
            'items.*.unit_detail' => 'nullable|string',
            'tax'                 => 'nullable|numeric|min:0',
            'paid'                => 'nullable|numeric|min:0',
            'notes'               => 'nullable|string',
            'currency'            => 'nullable|string',
        ]);

        $invoice->update([
            'number'        => $data['number'],
            'date'          => $data['date'],
            'customer_name' => $data['customer_name'] ?? null,
            'address'       => $data['address'] ?? null,
            'phone'         => $data['phone'] ?? null,
            'tax'           => $data['tax'] ?? 0,
            'paid'          => $data['paid'] ?? 0,
            'notes'         => $data['notes'] ?? null,
            'currency'      => $data['currency'] ?? 'IQD',
        ]);

        // Replace all items
        $invoice->items()->delete();
        foreach ($data['items'] as $item) {
            $invoice->items()->create([
                'name'        => $item['name'],
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['unit_price'],
                'unit_type'   => $item['unit_type']   ?? 'single',
                'unit_detail' => $item['unit_detail']  ?? null,
            ]);
        }

        return redirect()->route('invoice.show', $invoice->id);
    }

    /** Delete an invoice */
    public function destroy(int $id)
    {
        Invoice::findOrFail($id)->delete();
        return redirect()->route('invoices.index')->with('success', __('invoice.deleted'));
    }
}
