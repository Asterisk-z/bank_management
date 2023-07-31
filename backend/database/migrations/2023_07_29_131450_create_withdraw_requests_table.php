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
        Schema::create('withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->string('withdraw_ref');
            $table->bigInteger('user_id');
            $table->bigInteger('method_id');
            $table->string('currency');
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->string('attachment')->nullable();
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->bigInteger('transaction_id')->nullable();
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
        Schema::dropIfExists('withdraw_requests');
    }
};
