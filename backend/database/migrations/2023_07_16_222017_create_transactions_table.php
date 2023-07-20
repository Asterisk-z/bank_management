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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('currency');
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2);
            $table->enum('process', ['debit', 'credit']);
            $table->enum('method', ['manual', 'online', 'gift_card', 'payoneer', 'paypal', 'blockchain']);
            $table->enum('type', ['deposit', 'wire_transfer', 'exchange', 'send_money']);
            $table->enum('status', ['pending', 'awaiting_otp', 'approved', 'declined', 'canceled'])->default('pending');
            $table->string('transaction_ref');
            $table->string('btc_value')->nullable();
            $table->string('description')->nullable();
            $table->string('notify')->nullable();
            $table->string('receiver_id')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('deposit_ref')->nullable();
            $table->string('loan_id')->nullable();
            $table->string('x_currency')->nullable();
            $table->string('x_amount')->nullable();
            $table->string('gift_card_id')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
