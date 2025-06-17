<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoodsReceiptItem;

class GoodsReceiptItemController extends Controller
{
    public function index()
    {
        return response()->json(GoodsReceiptItem::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'goods_receipt_id' => 'required|exists:goods_receipts,id',
            'po_item_id' => 'required|exists:purchase_order_items,id',
            'qty_received' => 'required|integer',
            'condition' => 'required|string',
        ]);
        $item = GoodsReceiptItem::create($validated);
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = GoodsReceiptItem::findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = GoodsReceiptItem::findOrFail($id);
        $validated = $request->validate([
            'goods_receipt_id' => 'required|exists:goods_receipts,id',
            'po_item_id' => 'required|exists:purchase_order_items,id',
            'qty_received' => 'required|integer',
            'condition' => 'required|string',
        ]);
        $item->update($validated);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = GoodsReceiptItem::findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }
}
