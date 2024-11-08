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
        'order_identifier',
        'tracking_no',
        'order_date',
        'cost',
        'errors',
        'status',
        'created_by',
        'updated_by',
    ];
}
