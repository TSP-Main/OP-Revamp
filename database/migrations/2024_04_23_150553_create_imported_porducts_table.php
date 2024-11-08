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
        Schema::create('imported_porducts', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('desc')->nullable();
            $table->text('category')->nullable();
            $table->text('type')->nullable();
            $table->string('published')->nullable();
            $table->string('sku')->nullable();
            $table->string('weight')->nullable();
            $table->string('inventory_qty')->nullable();
            $table->string('inventory_policy')->nullable();
            $table->string('price')->nullable();
            $table->string('compare_price')->nullable();
            $table->string('barcode')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('imported_porducts');
    }
};
