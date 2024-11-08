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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->string('title')->nullable();
            $table->decimal('price',8,2)->nullable();
            $table->string('value')->nullable();
            $table->text('slug')->nullable();
            $table->string('barcode')->nullable();
            $table->string('inventory')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('cut_price',8,2)->nullable();
            $table->string('weight')->default(0);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('product_variants');
    }
};
