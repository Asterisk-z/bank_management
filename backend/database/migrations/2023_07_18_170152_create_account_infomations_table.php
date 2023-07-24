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
        Schema::create('account_infomations', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->decimal('usd_balance', 15, 2)->default('0');
            $table->decimal('aud_balance', 15, 2)->default('0');
            $table->decimal('eur_balance', 15, 2)->default('0');
            $table->string('account_number')->nullable()->unique();
            $table->string('first_card_number')->nullable()->unique();
            $table->string('seconds_card_number')->nullable()->unique();
            $table->decimal('first_card_balance', 15, 2)->default('0');
            $table->decimal('second_card_balance', 15, 2)->default('0');

            $table->enum('status', ['active', 'not_active']);
            $table->enum('usd_status', ['active', 'not_active'])->default('active');
            $table->enum('aud_status', ['active', 'not_active'])->default('active');
            $table->enum('eur_status', ['active', 'not_active'])->default('active');
            $table->enum('first_card_status', ['active', 'not_active'])->default('not_active');
            $table->enum('second_card_status', ['active', 'not_active'])->default('not_active');
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
        Schema::dropIfExists('account_infomations');
    }
};
