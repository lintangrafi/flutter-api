<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\GoodsReceiptController;
use App\Http\Controllers\Api\GoodsReceiptItemController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\InvoiceItemController;
use App\Http\Controllers\Api\PurchaseOrderActionController;
use App\Http\Controllers\Api\GoodsReceiptActionController;
use App\Http\Controllers\Api\InvoiceActionController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('purchase-orders')->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'index']);
    Route::get('{id}', [PurchaseOrderController::class, 'show']);
    Route::post('/', [PurchaseOrderController::class, 'store']);
    Route::patch('{id}/status', [PurchaseOrderController::class, 'updateStatus']);
});

// Approve PO (hanya manager/admin)
Route::patch('purchase-orders/{id}/approve', [PurchaseOrderActionController::class, 'approve'])->middleware('auth:sanctum');

Route::prefix('vendors')->group(function () {
    Route::get('/', [VendorController::class, 'index']);
    Route::get('{id}', [VendorController::class, 'show']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('{id}', [ProductController::class, 'show']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('warehouses', WarehouseController::class);
Route::get('warehouse', [WarehouseController::class, 'index']);

// Goods Receipts
Route::apiResource('goods-receipts', GoodsReceiptController::class);
// Set GR completed (hanya manager/admin)
Route::patch('goods-receipts/{id}/complete', [GoodsReceiptActionController::class, 'complete'])->middleware('auth:sanctum');
// Goods Receipt Items
Route::apiResource('goods-receipt-items', GoodsReceiptItemController::class);
// Invoices
Route::apiResource('invoices', InvoiceController::class);
// Set invoice paid (hanya manager/admin)
Route::patch('invoices/{id}/paid', [InvoiceActionController::class, 'paid'])->middleware('auth:sanctum');
// Invoice Items
Route::apiResource('invoice-items', InvoiceItemController::class);

/*
|--------------------------------------------------------------------------
| API Endpoint List
|--------------------------------------------------------------------------
*/

// Goods Receipts
// GET    /api/goods-receipts           -> list semua goods receipt
// POST   /api/goods-receipts           -> tambah goods receipt
// GET    /api/goods-receipts/{id}      -> detail goods receipt
// PUT    /api/goods-receipts/{id}      -> update goods receipt
// DELETE /api/goods-receipts/{id}      -> hapus goods receipt

// Goods Receipt Items
// GET    /api/goods-receipt-items           -> list semua goods receipt item
// POST   /api/goods-receipt-items           -> tambah goods receipt item
// GET    /api/goods-receipt-items/{id}      -> detail goods receipt item
// PUT    /api/goods-receipt-items/{id}      -> update goods receipt item
// DELETE /api/goods-receipt-items/{id}      -> hapus goods receipt item

// Invoices
// GET    /api/invoices           -> list semua invoice
// POST   /api/invoices           -> tambah invoice
// GET    /api/invoices/{id}      -> detail invoice
// PUT    /api/invoices/{id}      -> update invoice
// DELETE /api/invoices/{id}      -> hapus invoice

// Invoice Items
// GET    /api/invoice-items           -> list semua invoice item
// POST   /api/invoice-items           -> tambah invoice item
// GET    /api/invoice-items/{id}      -> detail invoice item
// PUT    /api/invoice-items/{id}      -> update invoice item
// DELETE /api/invoice-items/{id}      -> hapus invoice item

Route::prefix('goods-receipts')->group(function () {
    Route::get('/', [GoodsReceiptController::class, 'index']);
    Route::get('{id}', [GoodsReceiptController::class, 'show']);
    Route::post('/', [GoodsReceiptController::class, 'store']);
    Route::patch('{id}/status', [GoodsReceiptController::class, 'updateStatus']);
});

Route::get('/invoices', [\App\Http\Controllers\Api\InvoiceController::class, 'index']);
Route::post('/invoices', [\App\Http\Controllers\Api\InvoiceController::class, 'store']);
Route::get('/invoices/{id}', [\App\Http\Controllers\Api\InvoiceController::class, 'show']);
Route::patch('/invoices/{id}/status', [\App\Http\Controllers\Api\InvoiceController::class, 'updateStatus']);
