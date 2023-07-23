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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('ticket_ref');
            $table->string('subject');
            $table->string('description')->nullable();
            $table->enum('status', ['active', 'pending', 'closed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->integer('admin_id')->nullable();
            $table->string('attachment');
            $table->integer('closed_user_id')->nullable();
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
        Schema::dropIfExists('support_tickets');
    }
};
