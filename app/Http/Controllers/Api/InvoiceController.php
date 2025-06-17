<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        return response()->json(Invoice::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'po_id' => 'required|exists:purchase_orders,id',
            'total' => 'required|numeric',
            'status' => 'string',
            'created_by' => 'required|exists:users,id',
        ]);
        $invoice = Invoice::create($validated);
        return response()->json($invoice, 201);
    }

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return response()->json($invoice);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $validated = $request->validate([
            'po_id' => 'required|exists:purchase_orders,id',
            'total' => 'required|numeric',
            'status' => 'string',
            'created_by' => 'required|exists:users,id',
        ]);
        $invoice->update($validated);
        return response()->json($invoice);
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json(null, 204);
    }
}
