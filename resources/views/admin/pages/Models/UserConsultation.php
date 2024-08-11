<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_answers',
        'status',
        'created_by',
        'updated_by',
    ];
}
