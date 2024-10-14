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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('email')->nullable(); // In case the user is not logged in
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_notifications');
    }
}
