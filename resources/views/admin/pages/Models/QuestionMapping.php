<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionMapping extends Model
{
    use HasFactory;
    protected $table = 'question_mapping';

    protected $fillable = [
        'category_id',
        'question_id',
        'answer',
        'next_question',
        'status',
        'created_by',
    ];

    public function assignQuestion()
    {
        return $this->belongsTo(AssignQuestion::class, 'category_id', 'category_id');
    }
}
