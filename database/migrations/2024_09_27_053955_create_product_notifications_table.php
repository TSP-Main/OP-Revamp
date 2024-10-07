<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('product_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Nullable for non-logged-in users
            $table->unsignedBigInteger('product_id');

            // Add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Add unique index to prevent duplicate notifications
            $table->unique(['user_id', 'product_id']);

            $table->string('email')->nullable(); // In case the user is not logged in
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_notifications');
    }
}
