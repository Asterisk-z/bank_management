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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_ref');
            $table->string('loan_product_id');
            $table->string('borrower_id');
            $table->timestamp('first_payment_date');
            $table->string('currency');
            $table->decimal('applied_amount');
            $table->integer('created_user_id');
            $table->timestamp('release_date')->nullable();
            $table->decimal('total_payable')->default(0.00);
            $table->decimal('total_paid')->default(0.00);
            $table->string('late_payment_penalties')->nullable();
            $table->string('attachment')->nullable();
            $table->string('description')->nullable();
            $table->string('remarks')->nullable();
            $table->enum('status', ['approved', 'pending', 'declined', 'cleared'])->default('pending');
            $table->timestamp('approved_date')->nullable();
            $table->integer('approved_user_id')->nullable();
            $table->integer('branch_id')->default(1);
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
        Schema::dropIfExists('loans');
    }
};
