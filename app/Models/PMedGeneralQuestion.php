<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PMedGeneralQuestion extends Model
{
    use HasFactory;

    protected $table = 'p_med_general_questions';

    protected $fillable = [
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

    // If 'created_by' is an integer (foreign key), define the relationship if needed
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
  