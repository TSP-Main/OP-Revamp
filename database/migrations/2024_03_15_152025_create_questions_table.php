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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('category_title');
            $table->text('title');
            $table->text('desc')->nullable();
            $table->string('anwser_set');
            $table->string('type')->default('non_dependent');
            $table->text('yes_lable')->nullable();
            $table->text('no_lable')->nullable();
            $table->text('optA')->nullable();
            $table->text('optB')->nullable();
            $table->text('optC')->nullable();
            $table->text('optD')->nullable(); 
            $table->integer('order')->nullable();
            $table->string('is_dependent')->default('no');
            $table->string('is_assigned')->default('no');
            $table->string('status')->default('Active');
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('questions');
    }
};
