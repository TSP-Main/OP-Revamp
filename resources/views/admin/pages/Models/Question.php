<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'anwser_set',
        'openbox',
        'yes_lable',
        'no_lable',
        'optA',
        'optB',
        'optC',
        'optD',
        'created_by',
    ];

    public function assignments()
    {
        return $this->hasMany(AssignQuestion::class, 'question_id');
    }
}
