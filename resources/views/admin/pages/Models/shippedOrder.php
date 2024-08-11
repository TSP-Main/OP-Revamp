<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shippedOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'variant_id',
        'order_identifier',
        'tracking_id',
        'order_date',
        'quantity',
        'cost',
        'errors',
        'status',
        'created_by',
        'updated_by',
    ];
}
