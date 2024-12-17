<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('discount_type', ['percentage', 'fixed_amount', 'free_shipping']);
            $table->string('selection_type')->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->decimal('min_purchase_amount', 10, 2)->nullable();
            $table->integer('product_id')->nullable(); // Simplified as integer
            $table->integer('variant_id')->nullable(); // Simplified as integer
            $table->integer('category_id')->nullable(); // Simplified as integer
            $table->integer('subcategory_id')->nullable(); // Simplified as integer
            $table->integer('childcategory_id')->nullable(); // Simplified as integer
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->integer('max_usage')->nullable();
            $table->integer('max_usage_per_user')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
