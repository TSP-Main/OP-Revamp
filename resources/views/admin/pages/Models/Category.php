<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'publish',
        'status',
        'created_by',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function assignedQuestions()
    {
        return $this->hasMany(AssignQuestion::class, 'category_id');
    }

    public function questions()
    {
        return $this->hasManyThrough(
            Question::class,
            AssignQuestion::class,
            'category_id',
            'id',
            'id',
            'question_id'
        );
    }
}
