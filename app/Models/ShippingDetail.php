<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_identifier',
        'tracking_no',
        'zip_code',
        'user_id',
        'firstName',
        'lastName',
        'email',
        'phone',
        'city',
        'address',
        'address2',
        'method',
        'cost',
        'state',
        'status',
        'shipping_status',
        'created_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
