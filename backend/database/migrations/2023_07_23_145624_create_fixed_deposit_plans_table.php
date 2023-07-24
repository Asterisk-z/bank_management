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
        Schema::create('fixed_deposit_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('minimum_amount', 10, 2);
            $table->decimal('maximum_amount', 10, 2);
            $table->decimal('interest_rate', 10, 2);
            $table->integer('duration');
            $table->string('duration_type');
            $table->enum('status', ['active', 'not_active'])->default('active');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('fixed_deposit_plans');
    }
};
