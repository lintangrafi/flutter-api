<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoodsReceipt;

class GoodsReceiptController extends Controller
{
    public function index()
    {
        return response()->json(GoodsReceipt::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'po_id' => 'required|exists:purchase_orders,id',
            'tanggal' => 'required|date',
            'status' => 'string',
            'created_by' => 'required|exists:users,id',
        ]);
        $goodsReceipt = GoodsReceipt::create($validated);
        return response()->json($goodsReceipt, 201);
    }

    public function show($id)
    {
        $goodsReceipt = GoodsReceipt::findOrFail($id);
        return response()->json($goodsReceipt);
    }

    public function update(Request $request, $id)
    {
        $goodsReceipt = GoodsReceipt::findOrFail($id);
        $validated = $request->validate([
            'po_id' => 'required|exists:purchase_orders,id',
            'tanggal' => 'required|date',
            'status' => 'string',
            'created_by' => 'required|exists:users,id',
        ]);
        $goodsReceipt->update($validated);
        return response()->json($goodsReceipt);
    }

    public function destroy($id)
    {
        $goodsReceipt = GoodsReceipt::findOrFail($id);
        $goodsReceipt->delete();
        return response()->json(null, 204);
    }
}
