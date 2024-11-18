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
        Schema::table('product_variants', function (Blueprint $table) {
            // Add the stock_status column after the inventory column
            $table->enum('stock_status', ['IN', 'OUT'])->default('IN')->after('inventory')->comment('IN, OUT');
            
            // Add the low_limit column after stock_status
            $table->integer('low_limit')->default(5)->after('stock_status')->comment('Low stock for alerts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            // Remove the stock_status and low_limit columns
            $table->dropColumn(['stock_status', 'low_limit']);
        });
    }
};
