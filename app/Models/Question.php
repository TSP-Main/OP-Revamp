<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'category_title',
        'title',
        'desc',
        'anwser_set',
        'type',
        'yes_lable',
        'no_lable',
        'optA',
        'optB',
        'optC',
        'optD',
        'order',
        'is_dependent',
        'is_assigned',
        'status',
        'created_by',
    ];

    public function assignments()
    {
        return $this->hasMany(AssignQuestion::class, 'question_id');
    }
}
