<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['title', 'slug', 'min_buy','stock_status', 'high_risk', 'leaflet_link', 'max_buy', 'comb_variants', 'weight', 'category_id', 'sub_category', 'child_category', 'product_template', 'question_category', 'main_image', 'desc', 'short_desc', 'price', 'stock', 'low_limit', 'SKU', 'barcode', 'cut_price', 'status', 'created_by', 'updated_by'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sub_cat()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category');
    }

    public function child_cat()
    {
        return $this->belongsTo(ChildCategory::class, 'child_category');
    }

    public function assignedQuestions()
    {
        return $this->hasMany(AssignQuestion::class, 'category_id', 'category_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
