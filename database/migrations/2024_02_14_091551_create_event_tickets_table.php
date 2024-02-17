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
        Schema::create('event_tickets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->integer('event_id');
            $table->string('name_guest');
            $table->string('name_guest_arabic')->nullable();
            $table->string('guest_category');
            $table->string('guest_category_arabic')->nullable();
            $table->string('access_permitted');
            $table->string('access_permitted_arabic')->nullable();

            $table->integer('total_ticket');
            $table->integer('remaining_ticket');
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
        Schema::dropIfExists('event_tickets');
    }
};
