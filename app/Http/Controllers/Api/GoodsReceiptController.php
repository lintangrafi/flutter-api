<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoodsReceipt;
use Illuminate\Support\Facades\Log;

class GoodsReceiptController extends Controller
{
    public function index()
    {
        $data = GoodsReceipt::with(['items'])->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        \Log::info('GR Raw Request', ['request' => $request->all()]);
        logger()->info('GR Request Payload', ['request' => $request->all()]);
        try {
            $validated = $request->validate([
                'po_id' => 'required|integer|exists:purchase_orders,id',
                'gr_number' => 'required|string|unique:goods_receipts,gr_number',
                'tanggal' => 'required|date',
                'status' => 'required|string',
                'created_by' => 'required|integer',
                'items' => 'required|array|min:1',
                'items.*.po_item_id' => 'required|integer|exists:purchase_order_items,id',
                'items.*.qty_received' => 'required|integer',
                'items.*.condition' => 'required|string',
            ]);

            $po = \App\Models\PurchaseOrder::findOrFail($validated['po_id']);
            if ($po->status !== 'approved') {
                logger()->warning('PO not approved for GR', ['po_id' => $validated['po_id']]);
                return response()->json(['message' => 'PO must be approved to create GR'], 422);
            }

            $gr = \App\Models\GoodsReceipt::create([
                'po_id' => $validated['po_id'],
                'gr_number' => $validated['gr_number'],
                'tanggal' => $validated['tanggal'],
                'status' => $validated['status'],
                'created_by' => $validated['created_by'],
            ]);

            $itemsSaved = [];
            foreach ($validated['items'] as $item) {
                $savedItem = $gr->items()->create([
                    'po_item_id' => $item['po_item_id'],
                    'qty_received' => $item['qty_received'],
                    'condition' => $item['condition'],
                ]);
                $itemsSaved[] = $savedItem;
            }
            logger()->info('GR Saved', ['gr' => $gr, 'items' => $itemsSaved]);
            return response()->json($gr->load(['items', 'purchaseOrder', 'creator']), 201);
        } catch (\Exception $e) {
            logger()->error('GR Store Error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Failed to create GR', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $goodsReceipt = GoodsReceipt::with(['items'])->findOrFail($id);
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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Completed'
        ]);
        $gr = GoodsReceipt::with('items')->findOrFail($id);
        $gr->status = $request->status;
        $gr->save();
        return response()->json($gr, 200);
    }
}
