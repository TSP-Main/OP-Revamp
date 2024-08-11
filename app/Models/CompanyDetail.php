<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
    ];

    protected $fillable = ['detail_type', 'content_type','content','status', 'created_by', 'updated_by'];

}
