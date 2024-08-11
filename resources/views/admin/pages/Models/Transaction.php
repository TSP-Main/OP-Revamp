<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'product_id',
        'category_id',
        'question_answers',
        'status',
        'created_by',
        'updated_by',
    ];
}
