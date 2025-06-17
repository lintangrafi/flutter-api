<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'po_item_id',
        'qty',
        'price',
        'subtotal',
    ];
}
