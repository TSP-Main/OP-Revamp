<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqProduct extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
    ];

    protected $fillable = ['product_id', 'product_title','order', 'title', 'desc', 'status', 'created_by', 'updated_by'];

}
