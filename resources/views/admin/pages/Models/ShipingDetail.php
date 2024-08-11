<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipingDetail extends Model
{
    use HasFactory;
    
    protected $fillable = ['order_id','zip_code','user_id','firstName','lastName','phone','old_address','quantity','city','address','address2' ,'method','cost', 'status','created_by','updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
