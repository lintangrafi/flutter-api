<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoiceItem;

class InvoiceItemController extends Controller
{
    public function index()
    {
        return response()->json(InvoiceItem::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'po_item_id' => 'required|exists:purchase_order_items,id',
            'qty' => 'required|integer',
            'price' => 'required|numeric',
            'subtotal' => 'required|numeric',
        ]);
        $item = InvoiceItem::create($validated);
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = InvoiceItem::findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = InvoiceItem::findOrFail($id);
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'po_item_id' => 'required|exists:purchase_order_items,id',
            'qty' => 'required|integer',
            'price' => 'required|numeric',
            'subtotal' => 'required|numeric',
        ]);
        $item->update($validated);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = InvoiceItem::findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }
}
