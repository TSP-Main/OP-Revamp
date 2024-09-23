<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipingDetail extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','zip_code','user_id','firstName','lastName','email','phone','old_address','city','address','address2' ,'method','cost', 'state', 'status','created_by','updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
