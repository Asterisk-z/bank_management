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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('name');
            $table->string('country_code');
            $table->string('phone');
            $table->string('email')->unique();
            $table->enum('user_type', ['admin', 'customer'])->default('customer');
            $table->enum('status', ['active', 'not_active', 'pending'])->default('active');
            $table->enum('email_verified', ['yes', 'no'])->default('no');
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('sms_verified', ['yes', 'no'])->default('no');
            $table->timestamp('sms_verified_at')->nullable();
            $table->string('password');
            $table->string('temp_password')->nullable();
            $table->enum('create_by_admin', ['yes', 'no'])->default('no');
            $table->string('account_number')->nullable();
            $table->bigInteger('role_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->enum('kyc_status', ['yes', 'no'])->default('no');
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
