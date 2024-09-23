<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientQuery extends Model
{
    use HasFactory;

    
    protected $dates = [
        'created_at',
    ];

    protected $fillable = ['user_id','type', 'email', 'name','subject','message','status', 'created_by', 'updated_by'];

}
