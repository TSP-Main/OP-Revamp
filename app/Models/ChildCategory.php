<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'name',
        'slug',
        'desc',
        'publish',
        'status',
        'image',
        'icon',
        'created_by',
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'child_category');
    }
}
