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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('reset_pswd_time')->nullable();
            $table->string('reset_pswd_attempt')->nullable();
            $table->integer('otp')->nullable();
//            $table->boolean('otp_verified')->default(0);
            $table->text('id_document')->nullable();
            $table->boolean('status')->default(2)->comment('1: active, 2: pending,
             3: suspended, 4: unverified, 5: deleted');
//            $table->boolean('is_active')->default(1)->comment('0: inactive, 1: active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable()->default(null);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
