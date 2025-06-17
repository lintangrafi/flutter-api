<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    protected $fillable = [
        'po_id',
        'tanggal',
        'status',
        'created_by',
    ];
}
