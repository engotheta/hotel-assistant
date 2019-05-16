<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handovers', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('to_id')->unsigned();     // name of the person who handing it over to
            $table->bigInteger('amount');
            $table->string('details')->nullable();

            $table->bigInteger('user_id')->unsigned(); // user handing over the money

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
        Schema::dropIfExists('handovers');
    }
}
