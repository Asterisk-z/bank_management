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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('code');
            $table->string('currency');
            $table->decimal('amount', 15, 2);
            $table->enum('is_general', ['yes', 'no']);
            $table->enum('status', ['used', 'active', 'expired', 'canceled']);
            $table->timestamp('active_till');
            $table->timestamp('stopped_at')->nullable();
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
        Schema::dropIfExists('gift_cards');
    }
};
