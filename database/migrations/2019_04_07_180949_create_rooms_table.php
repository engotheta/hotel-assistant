<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('details')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('holiday_price')->nullable();
            $table->integer('floor')->default(0);
            $table->string('image')->nullable();
            $table->bigInteger('count')->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('booked')->default(true);
            $table->boolean('ac')->default(false);
            $table->boolean('fan')->default(true);

            $table->bigInteger('room_type_id')->unsigned()->default(1);
            $table->bigInteger('branch_id')->unsigned()->default(1) ;
            $table->bigInteger('creator_id')->unsigned()->nullable();

            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('room_type_id')->references('id')->on('room_types');
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
        Schema::dropIfExists('rooms');
    }
}
