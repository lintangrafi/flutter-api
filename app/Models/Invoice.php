<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'po_id',
        'total',
        'status',
        'created_by',
    ];
}
