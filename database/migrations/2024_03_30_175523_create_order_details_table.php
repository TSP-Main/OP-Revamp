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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('variant_id')->constrained('product_variants')->nullable();
//            $table->bigInteger('weight');
//            $table->text('product_name');
//            $table->text('variant_details')->nullable();
            $table->string('product_qty');
//            $table->string('product_price');
            $table->text('generic_consultation')->nullable();
            $table->text('product_consultation')->nullable();
            $table->string('consultation_type')->nullable();
//            $table->string('status')->default('1');
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('order_details');
    }
};
