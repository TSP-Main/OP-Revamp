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
        Schema::create('human_request_forms', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->string('title')->nullable();
            $table->string('enquiry_type')->nullable();
            $table->string('device_type')->nullable();
            $table->string('nhs_login')->nullable();
            $table->string('file')->nullable();
            $table->text('desc')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('Active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('human_request_forms');
    }
};
