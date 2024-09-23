<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PrescriptionMedGeneralQuestion extends Model
{
    use HasFactory;

    protected $table = 'prescription_med_general_questions';

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


}