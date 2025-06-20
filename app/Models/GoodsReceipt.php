<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    protected $fillable = [
        'gr_number',
        'po_id',
        'tanggal',
        'status',
        'created_by',
    ];

    public function items()
    {
        return $this->hasMany(\App\Models\GoodsReceiptItem::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(\App\Models\PurchaseOrder::class, 'po_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
