<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('desc');
            $table->text('main_image');
            $table->decimal('price',8,2);
            $table->string('stock');
            $table->string('weight')->default(0);
            $table->string('min_buy')->nullable();
            $table->string('max_buy')->nullable();
            $table->string('comb_variants')->nullable();
            $table->string('SKU')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('cut_price',8,2)->nullable();
            $table->unsignedBigInteger('category_id');
            $table->integer('sub_category')->nullable();
            $table->integer('child_category')->nullable();
            $table->integer('product_template');
            $table->text('question_category')->nullable();
            $table->string('status')->default('1');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
