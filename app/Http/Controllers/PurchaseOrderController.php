<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $data = PurchaseOrder::with('vendor', 'items')->get();
        foreach ($data as $po) {
            $po->formatted_total = $this->formatPrice($po->total);
            foreach ($po->items as $item) {
                $item->formatted_price = $this->formatPrice($item->price);
            }
        }
        return response()->json($data);
    }

    public function show($id)
    {
        $po = PurchaseOrder::with('vendor', 'items')->findOrFail($id);
        $po->formatted_total = $this->formatPrice($po->total);
        foreach ($po->items as $item) {
            $item->formatted_price = $this->formatPrice($item->price);
        }
        return response()->json($po);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'po_number' => 'required|unique:purchase_orders,po_number',
            'vendor_id' => 'required|exists:vendors,id',
            'date' => 'required|date',
            'created_by' => 'required|exists:users,id',
            'warehouse_id' => 'required|exists:warehouses,id', // Validasi warehouse_id
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string', // Menambahkan validasi untuk field name
            'items.*.unit' => 'required|string', // Menambahkan validasi untuk field unit
            'items.*.product_id' => 'required|exists:products,id', // Menambahkan validasi untuk field product_id
            'items.*.price' => 'required|numeric', // Menambahkan validasi untuk field price
            'items.*.quantity' => 'required|integer|min:1', // Menambahkan validasi untuk field quantity
            'total' => 'required|numeric', // Menambahkan validasi untuk field total
        ]);

        $po = PurchaseOrder::create([
            'po_number' => $validated['po_number'],
            'vendor_id' => $validated['vendor_id'],
            'date' => $validated['date'],
            'warehouse_id' => $validated['warehouse_id'],
            'created_by' => $validated['created_by'],
            'total' => $validated['total'], // Menambahkan total dari request
        ]);

        $total = 0;
        foreach ($validated['items'] as $item) {
            $item['po_id'] = $po->id; // Set po_id sesuai dengan PO induk
            $item['name'] = $item['name'] ?? ''; // Menambahkan default value untuk field name jika tidak ada di request
            $item['unit'] = $item['unit'] ?? ''; // Menambahkan default value untuk field unit jika tidak ada di request
            $item['product_id'] = $item['product_id'] ?? null; // Menambahkan default value untuk field product_id jika tidak ada di request
            $item['price'] = $item['price'] ?? 0; // Menambahkan default value untuk field price jika tidak ada di request
            $item['quantity'] = $item['quantity'] ?? 1; // Menambahkan default value untuk field quantity jika tidak ada di request
            $po->items()->create($item);
            $total += $item['price'] * $item['quantity'];
        }

        $po->update(['total' => $total]);
        $po->refresh();
        $po->formatted_total = $this->formatPrice($po->total);
        foreach ($po->items as $item) {
            $item->formatted_price = $this->formatPrice($item->price);
        }
        return response()->json($po->load('items'), 201);
    }

    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:Draft,Approved,Completed,Pending,Paid' // Update validasi untuk status
        ]);

        try {
            $po = PurchaseOrder::findOrFail($id);
            if (!$po) {
                return response()->json(['message' => 'Purchase Order not found'], 404);
            }

            logger()->info("Updating status for Purchase Order ID: {$id}", ['current_status' => $po->status]);

            $po->status = $request->input('status');
            $saveResult = $po->save();

            // Remap all 'Disetujui' statuses to 'approved'
            DB::table('purchase_orders')->where('status', 'Disetujui')->update(['status' => 'approved']);

            if (!$saveResult) {
                return response()->json(['message' => 'Failed to save status update'], 500);
            }

            logger()->info("Status updated successfully for Purchase Order ID: {$id}", ['new_status' => $po->status]);

            return response()->json(['message' => 'Status updated successfully', 'status' => $po->status]);
        } catch (Exception $e) {
            logger()->error("Error updating status for Purchase Order ID: {$id}", ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to update status', 'error' => $e->getMessage()], 500);
        }
    }

    public function formatPrice($value)
    {
        // Format angka menjadi 15.000 (tanpa desimal, dengan titik ribuan)
        return number_format($value, 0, '', '.');
    }
}
