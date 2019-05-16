<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->unique();
            $table->string('slug');
            $table->string('details')->nullable();
            $table->integer('floors')->nullable();

            $table->bigInteger('creator_id')->unsigned()->nullable();
            $table->bigInteger('contact_person_id')->unsigned()->nullable();
            $table->bigInteger('address_id')->unsigned()->nullable();

            $table->foreign('address_id')->references('id')->on('addresses');

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
        Schema::dropIfExists('branches');
    }

    private function seed(){
        DB::table('branches')->insert([
                 'name' =>'main',
                 'details' =>'you can rename this branch',
                 'slug' =>'main',
             ]);
    }
}
