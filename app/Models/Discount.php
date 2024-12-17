<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's naming convention)
    protected $table = 'discounts';

    // Mass assignable attributes
    protected $fillable = [
        'code',
        'discount_type',
        'selection_type',
        'value',
        'min_purchase_amount',
        'product_id',
        'variant_id',
        'category_id',
        'subcategory_id',
        'childcategory_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'max_usage',
        'max_usage_per_user',
        'is_active',
    ];

    // Casts for date/time fields
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'start_time' => 'datetime:H:i',  // Custom format
        'end_time' => 'datetime:H:i',    // Custom format
        'is_active' => 'boolean',
    ];

    // You can also add relationships if you need to link with other models
    // For example, if there are related product, category, subcategory models, you can define them like this:
    
    // public function product() {
    //     return $this->belongsTo(Product::class);
    // }

    // public function category() {
    //     return $this->belongsTo(Category::class);
    // }

    // public function subcategory() {
    //     return $this->belongsTo(Subcategory::class);
    // }

    // public function childcategory() {
    //     return $this->belongsTo(Childcategory::class);
    // }
}
