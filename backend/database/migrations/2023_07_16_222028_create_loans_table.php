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
            $table->string('borrower_id');
$table->string('first_payment_date');
            $table->string('release_date');
            $table->string('currency');
            $table->string('applied_amount');
            $table->string('total_payable');
            $table->string('total_paid');
            $table->string('late_payment_penalties');
            $table->string('attachment');
            $table->string('description');
            $table->string('remarks');
            $table->enum('status', ['active', 'not_active']);
$table->string('approved_date');
$table->string('approved_date');
$table->string('approved_date');
$table->string('approved_date');
$table->string('approved_date');
$table->string('approved_date');

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
Electronic Check for deposit
