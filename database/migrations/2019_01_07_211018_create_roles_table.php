<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->unique();
            $table->string('details')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();

            $table->bigInteger('creator_id')->unsigned()->nullable();
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
        Schema::dropIfExists('roles');
    }

    private function seed(){
       DB::table('roles')->insert([
               'name' => 'not a user',
               'details' =>  'cannot login to this system',
        ]);

       DB::table('roles')->insert([
                'name' => 'user',
                'details' =>  'an ordinary user can login with minimal privelages, can only view,iniate and update a businessday'
         ]);

       DB::table('roles')->insert([
               'name' => 'admin',
               'details' =>  'a user with admistration privelages, can add and delete items'
        ]);
   }
}
