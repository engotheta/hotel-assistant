<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('details');
            $table->bigInteger('amount')->nullable(); //price for the booked iteme at the time of booking
            $table->bigInteger('paid')->nullable();  //amount paid so for this loan
            $table->boolean('complete')->default(0);  //only if paid full amount == paid
            $table->string('client')->nullable();  //only if loaner is not a member

            $table->string('loanable_type');  // references the actual asset or money (room/drink/food)
            $table->bigInteger('loanable_id')->unsigned();

            $table->bigInteger('user_id')->unsigned()->nullable(); //if not client
            $table->bigInteger('businessday_id')->unsigned();
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->bigInteger('activity_id')->unsigned()->nullable();
            $table->bigInteger('branch_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');  //only if loaner is a member
            $table->foreign('businessday_id')->references('id')->on('businessdays');
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
        Schema::dropIfExists('loans');
    }
}
