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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('swift_code');
            $table->string('bank_country');
            $table->string('bank_currency');
            $table->decimal('minimum_transfer_amount', 10, 2);
            $table->decimal('maximum_transfer_amount', 10, 2);
            $table->decimal('fixed_charge', 10, 2);
            $table->decimal('charge_in_percentage', 10, 2);
            $table->string('descriptions')->nullable();
            $table->enum('status', ['active', 'not_active'])->default('active');
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
        Schema::dropIfExists('banks');
    }
};
