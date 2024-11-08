<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
    ];

    protected $fillable = ['order_id','orderCode','amount','transactionId', 'fullName', 'email', 'cardNumber', 'statusId', 'insDate',  'status', 'created_by', 'updated_by'];

}
