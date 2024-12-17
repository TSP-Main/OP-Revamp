<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsageLogsTable extends Migration
{
    public function up()
    {
        Schema::create('usage_logs', function (Blueprint $table) {
            $table->id();
            
            // Foreign key linking to the discounts table
            $table->foreignId('discount_id')->constrained('discounts')->onDelete('cascade');
            
            // User who used the discount
            $table->unsignedBigInteger('user_id');
            
            // Timestamp for when the discount was used
            $table->dateTime('used_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            
            // Indexing user_id and the combination of discount_id and user_id to optimize queries
            $table->index('user_id');
            $table->index(['discount_id', 'user_id']); // Optimize queries for user-specific usage
        });
    }

    public function down()
    {
        Schema::dropIfExists('usage_logs');
    }
}
