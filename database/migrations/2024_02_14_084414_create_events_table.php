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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('name');
            $table->string('date');
            $table->string('venue');

            $table->string('header')->nullable();
            $table->string('partner_logo')->nullable();
            $table->string('aminity_logo')->nullable();
            $table->string('entry_message')->nullable();
            $table->string('venue_location')->nullable();

            $table->string('bg_image')->nullable();
            $table->string('font_color')->default('#000000');
            $table->string('font_family')->default('Arial');

            $table->enum('status', [1, 2])->default(1)->comment('1=Active, 2=Inactive');
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
        Schema::dropIfExists('events');
    }
};
