<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('details')->nullable();
            $table->integer('attendants')->nullable();
            $table->bigInteger('food_budget')->unsigned();   // 0 implies no foo
            $table->bigInteger('drinks_budget')->unsigned();
            $table->bigInteger('food_paid')->nullable()->unsigned();
            $table->bigInteger('drinks_paid')->nullable()->unsigned();
            $table->boolean('complete')->default(0); // 1 if paid = budget for all

            $table->bigInteger('booking_id')->unsigned();
            $table->bigInteger('venue_id')->unsigned();

            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('venue_id')->references('id')->on('venues');

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
}
