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
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('code');
            $table->timestamp('expires_at');
            $table->string('trans_id')->nullable();
            $table->enum('status', ['active', 'expired', 'used'])->default('active');
            $table->enum('use', ['transaction', 'login', 'register', '2fa'])->default('transaction');
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
        Schema::dropIfExists('otp_codes');
    }
};
