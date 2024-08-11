<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('email');
            $table->bigInteger('shipped_order_id')->nullable();
            $table->string('note')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_value')->nullable();
            $table->string('print')->default('Print Out');
            $table->string('total_ammount');
            $table->string('shiping_cost');
            $table->string('payment_id')->nullable();
            $table->string('order_identifier')->nullable();
            $table->string('tracking_no')->nullable();
            $table->string('payment_status')->default('Unpaid');
            $table->text('hcp_remarks')->nullable();
            $table->string('order_for')->default('despensory');
            $table->string('status')->default('Received');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable()->default(null);
            $table->unsignedBigInteger('updated_by')->nullable()->default(null);
            $table->timestamps();
        });

        DB::statement("ALTER TABLE orders AUTO_INCREMENT = 240011;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
