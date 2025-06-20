<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\GoodsReceipt;

class InvoiceController extends Controller
{
    public function index()
    {
        return response()->json(Invoice::with('goodsReceipt')->get());
    }

    public function show($id)
    {
        $invoice = Invoice::with('goodsReceipt')->findOrFail($id);
        return response()->json($invoice);
    }

    public function store(Request $request)
    {
        $request->validate([
            'gr_id' => 'required|exists:goods_receipts,id',
            'date' => 'required|date',
            'total' => 'required|numeric',
            'status' => 'required|in:Draft,Paid'
        ]);
        $gr = GoodsReceipt::findOrFail($request->gr_id);
        if ($gr->status !== 'Completed') {
            return response()->json(['error' => 'GR belum Completed'], 422);
        }
        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . now()->format('YmdHis'),
            'gr_id' => $gr->id,
            'date' => $request->date,
            'total' => $request->total,
            'status' => $request->status,
        ]);
        return response()->json($invoice->load('goodsReceipt'), 201);
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Draft,Paid'
        ]);
        $invoice = Invoice::findOrFail($id);
        $invoice->status = $request->status;
        $invoice->save();
        return response()->json($invoice, 200);
    }
}
