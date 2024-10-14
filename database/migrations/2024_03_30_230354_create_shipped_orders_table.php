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
        Schema::create('shipped_orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->bigInteger('order_id');
            $table->string('order_identifier')->nullable();
            $table->string('tracking_no')->nullable();
            $table->string('order_date')->nullable();
            $table->string('cost');
            $table->string('errors')->nullable();
            $table->string('status')->default('ShippingFail');
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
        Schema::dropIfExists('shipped_orders');
    }
};
