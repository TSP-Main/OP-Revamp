<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $dates = [
        'created_at',
    ];

    protected $fillable = ['user_id','shipped_order_id', 'product_id', 'variant_id', 'quantity', 'note', 'shiping_cost', 'coupon_value', 'coupon_code', 'total_ammount', 'payment_id', 'payment_status', 'status', 'created_by', 'updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function shipingdetails()
    {
        return $this->hasOne(ShipingDetail::class, 'order_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
