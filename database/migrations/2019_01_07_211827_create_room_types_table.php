<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->unique();
            $table->string('details')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();

            $table->bigInteger('creator_id')->unsigned()->nullable();

            $table->foreign('creator_id')->references('id')->on('users');

            $table->timestamps();
        });

      $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_types');
    }

    private function seed(){
       DB::table('room_types')->insert([
               'name' => 'single',
               'details' =>  'one bed',
        ]);
   }
}
