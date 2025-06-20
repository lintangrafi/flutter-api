<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoodsReceiptController extends Controller
{
    public function index()
    {
        $data = GoodsReceipt::with(['items.purchaseOrderItem', 'purchaseOrder', 'creator'])->get();
        return response()->json($data);
    }

    public function show($id)
    {
        $gr = GoodsReceipt::with(['items.purchaseOrderItem', 'purchaseOrder', 'creator'])->findOrFail($id);
        return response()->json($gr);
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

            $po = PurchaseOrder::findOrFail($validated['po_id']);
            if ($po->status !== 'approved') {
                logger()->warning('PO not approved for GR', ['po_id' => $validated['po_id']]);
                return response()->json(['message' => 'PO must be approved to create GR'], 422);
            }

            $gr = GoodsReceipt::create([
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

    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Completed',
        ]);
        $gr = GoodsReceipt::findOrFail($id);
        $user = Auth::user();
        if ($validated['status'] === 'Completed' && (!$user || $user->role !== 'manager')) {
            return response()->json(['message' => 'Only manager can complete GR'], 403);
        }
        $gr->status = $validated['status'];
        $gr->save();
        // Opsional: update status PO jika semua item sudah diterima
        // ...implementasi opsional di sini...
        return response()->json(['message' => 'Status updated', 'gr_number' => $gr->gr_number, 'status' => $gr->status]);
    }
}
