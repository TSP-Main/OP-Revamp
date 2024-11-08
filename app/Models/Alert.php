<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'body',
        'route',
        'slug',
        'question',
        'question_id',
        'q_category_id',
        'user_id',
        'status',
        'question_type',
        'created_by',
        'updated_by',
    ];

}
