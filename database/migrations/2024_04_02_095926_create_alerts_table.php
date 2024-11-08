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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('body');
            $table->string('route');
            $table->string('slug')->nullable();
            $table->string('question')->nullable();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->unsignedBigInteger('option')->nullable();
            $table->unsignedBigInteger('q_category_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('Active');
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
        Schema::dropIfExists('alerts');
    }
};
