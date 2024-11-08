<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'email_logs';

    // Fillable fields to allow mass assignment
    protected $fillable = [
        'order_id',
        'email_to',
        'subject',
        'body',
    ];

    // Define the relationship to the Order model
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
