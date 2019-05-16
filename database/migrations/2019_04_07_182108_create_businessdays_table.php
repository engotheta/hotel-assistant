<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessdaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businessdays', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');  //formated 01-12-2019
            $table->string('slug');
            $table->string('details')->nullable();
            $table->bigInteger('sales')->nullable();
            $table->bigInteger('paid_loans')->nullable();
            $table->bigInteger('bookings')->nullable();
            $table->bigInteger('pettycash')->nullable();
            $table->bigInteger('purchases')->nullable();
            $table->bigInteger('expenditures')->nullable();
            $table->bigInteger('loans')->nullable();
            $table->bigInteger('loss')->nullable();
            $table->boolean('complete')->default(0);

            $table->bigInteger('creator_id')->unsigned()->nullable(); // user iniating the day
            $table->bigInteger('user_id')->unsigned(); // user on shift of the day
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->bigInteger('activity_id')->unsigned()->nullable();
            $table->bigInteger('branch_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('activity_id')->references('id')->on('activities');
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
        Schema::dropIfExists('businessdays');
    }
}
