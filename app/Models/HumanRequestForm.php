<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HumanRequestForm extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'email',
        'phone',
        'subject',
        'title',
        'enquiry_type',
        'device_type',
        'nhs_login',
        'file',
        'desc',
        'message',
        'status',
        'created_by',
        'updated_by',
    ];
}
