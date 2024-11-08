<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'question_id',
        'question_title',
        'category_title',
        'is_dependent',
        'status',
        'created_by',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function questionMappings()
    {
        return $this->hasMany(QuestionMapping::class, 'category_id', 'category_id');
    }
}
