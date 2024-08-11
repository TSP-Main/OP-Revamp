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
            $table->string('gender');
            $table->string('dob')->nullable();
            $table->string('password')->nullable();
            $table->string('speciality')->nullable();
            $table->text('short_bio')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('id_document')->nullable();
            $table->text('apartment')->nullable();
            $table->string('role')->nullable();
            $table->string('user_pic')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->integer('otp')->nullable();
            $table->string('reset_pswd_time')->nullable();
            $table->string('reset_pswd_attempt')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable()->default(null);
            $table->unsignedBigInteger('sadmin_id')->nullable()->default(null);
            $table->unsignedBigInteger('manager_id')->nullable()->default(null);
            $table->string('profile_status')->default('pending');
            $table->string('consult_status')->default('pending');
            $table->string('status')->default('2');
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
