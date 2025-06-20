<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'gr_id',
        'date',
        'total',
        'status',
    ];

    public function goodsReceipt()
    {
        return $this->belongsTo(\App\Models\GoodsReceipt::class, 'gr_id');
    }
}
