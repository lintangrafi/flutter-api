<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'vendor_id',
        'date',
        'status',
        'total_amount',
        'created_by',
        'warehouse_id',
        'total',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'po_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function itemsByNumber()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'po_number', 'po_number');
    }

    public function getTotalAttribute($value)
    {
        return number_format($value, 0, '', '.');
    }
}
