<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        return response()->json(PurchaseOrder::with('vendor', 'items')->get());
    }

    public function show($id)
    {
        $po = PurchaseOrder::with('vendor', 'items')->findOrFail($id);
        return response()->json($po);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'po_number' => 'required|unique:purchase_orders,po_number',
            'vendor_id' => 'required|exists:vendors,id',
            'date' => 'required|date',
            'created_by' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
        ]);

        $po = PurchaseOrder::create([
            'po_number' => $validated['po_number'],
            'vendor_id' => $validated['vendor_id'],
            'date' => $validated['date'],
            'created_by' => $validated['created_by'],
            'total' => 0,
        ]);

        $total = 0;
        foreach ($validated['items'] as $item) {
            $po->items()->create($item);
            $total += $item['price'] * $item['quantity'];
        }

        $po->update(['total' => $total]);

        return response()->json($po->load('items'), 201);
    }

    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu Persetujuan,Disetujui,Dikirim,Dibatalkan'
        ]);

        $po = PurchaseOrder::findOrFail($id);
        $po->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Status updated']);
    }
}
