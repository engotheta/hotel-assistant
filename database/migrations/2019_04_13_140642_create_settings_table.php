<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('value');

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
        Schema::dropIfExists('settings');
    }

    private function seed(){
        DB::table('settings')->insert([
                 'name' =>'hotel_name',
                 'value' =>'Lunchtime',
             ]);

         DB::table('settings')->insert([
                  'name' =>'back_track_days',
                  'value' =>30,
              ]);

          DB::table('settings')->insert([
                   'name' =>'min drink stock',
                   'value' =>5,
               ]);
    }
}
