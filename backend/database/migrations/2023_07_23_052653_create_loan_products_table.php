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
        Schema::create('loan_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('minimum_amount', 10, 2);
            $table->decimal('maximum_amount', 10, 2);
            $table->string('description')->nullable();
            $table->decimal('interest_rate', 10, 2);
            $table->string('interest_type');
            $table->string('term');
            $table->string('term_period');
            $table->enum('status', ['active', 'not_active']);
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
        Schema::dropIfExists('loan_products');
    }
};
