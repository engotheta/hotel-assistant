<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remarks', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('remark');
            $table->boolean('solved')->default(false);

            $table->string('remarkable_type'); // references the actual asset/expense/member/department/branch
            $table->bigInteger('remarkable_id')->unsigned();

            $table->bigInteger('creator_id')->unsigned()->nullable();  //remarker
            $table->bigInteger('branch_id')->unsigned();  //remarker
            $table->bigInteger('businessday_id')->unsigned();

            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('businessday_id')->references('id')->on('businessdays');

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
        Schema::dropIfExists('remarks');
    }
}
