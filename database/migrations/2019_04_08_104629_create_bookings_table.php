<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('client');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('due_date');
            $table->string('details');
            $table->bigInteger('price')->nullable(); //price for the booked iteme at the time of booking
            $table->bigInteger('paid')->nullable();  //amount paid so for this booking
            $table->boolean('complete')->default(0);  //only if paid full

            $table->bigInteger('bookable_type'); // references the actual asset, if venue an event created
            $table->bigInteger('bookable_id')->unsigned();

            $table->bigInteger('businessday_id')->unsigned();
            $table->bigInteger('branch_id')->unsigned();

            $table->foreign('businessday_id')->references('id')->on('businessdays');
            $table->foreign('branch_id')->references('id')->on('branches');

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
        Schema::dropIfExists('bookings');
    }
}
