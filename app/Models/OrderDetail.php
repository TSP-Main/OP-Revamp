<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'weight',
        'product_name',
        'variant_details',
        'product_qty',
        'product_price',
        'generic_consultation',
        'product_consultation',
        'consultation_type',
        'status',
        'created_by',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
