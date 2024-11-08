<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedPorduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'desc', 'category', 'type', 'published',
        'sku', 'weight', 'inventory_qty', 'inventory_policy',
        'price', 'compare_price', 'barcode', 'status',
    ];
}
