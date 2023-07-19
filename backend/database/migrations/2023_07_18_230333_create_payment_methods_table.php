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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('currency_id')->nullable();
            $table->decimal('minimum_amount', 12, 2)->nullable();
            $table->decimal('maximum_amount', 12, 2)->nullable();
            $table->decimal('fixed_charge', 12, 2)->nullable();
            $table->decimal('charge_in_percentage', 12, 2)->nullable();
            $table->string('descriptions');
            $table->enum('status', ['active', 'not_active'])->default('active');
            $table->string('requirements')->nullable();
            $table->enum('type', ['withdrawal', 'deposit']);
            $table->enum('process', ['automatic', 'manual'])->nullable();
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
        Schema::dropIfExists('payment_methods');
    }
};
