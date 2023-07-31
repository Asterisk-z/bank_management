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
        Schema::create('fixed_deposits', function (Blueprint $table) {
            $table->id();
            $table->string('ref');
            $table->integer('fdr_plan_id');
            $table->integer('user_id');
            $table->string('currency');
            $table->decimal('deposit_amount');
            $table->decimal('return_amount');
            $table->string('attachment')->nullable();
            $table->string('remarks')->nullable();
            $table->enum('status', ['approved', 'pending', 'declined'])->default('pending');
            $table->timestamp('approved_date')->nullable();
            $table->timestamp('mature_date')->nullable();
            $table->integer('transaction_id')->nullable();
            $table->integer('approved_user_id')->nullable();
            $table->integer('created_user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->string('branch_id')->default('1');
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
        Schema::dropIfExists('fixed_deposits');
    }
};
