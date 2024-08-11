<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBmi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bmi',
        'cm',
        'feet',
        'inches',
        'weight_lb',
        'weight_kg',
        'weight_st',
        'weight_pic',
        'age',
        'gender',
        'status',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
