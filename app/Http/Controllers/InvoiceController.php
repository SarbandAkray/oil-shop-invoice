<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //

    public function create()
    {
        return view('invoice');
    }
    public function store(Request $request)
    {
        // Validate and store invoice data if needed
        $data = $request->validate([
            'number' => 'required',
            'date' => 'required',
            'customer_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'items' => 'required|array',
            'items.*.name' => 'required',
            'items.*.quantity' => 'required|numeric',
            'items.*.unit_price' => 'required|numeric',
            'tax' => 'nullable|numeric',
        ]);
        session(['invoice' => $data]);
        return redirect()->route('invoice.print');
    }
    public function print(Request $request)
    {
        $invoice = session('invoice');
        if (!$invoice) {
            return redirect()->route('invoice.create')->with('error', 'No invoice data found.');
        }
        return view('invoice', compact('invoice'));
    }
}
