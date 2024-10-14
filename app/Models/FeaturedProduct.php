<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FeaturedProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id',
        'status',
        'created_by',
        'updated_by',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
