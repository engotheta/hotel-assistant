<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('salary');      //salary amount at the time of paying
            $table->bigInteger('loan');       //amount of unpaid loan from the loans
            $table->bigInteger('payable');    // default salary - loan / paidloan = salary - payable
            $table->bigInteger('paid')->nullable();
            $table->string('details')->nullable();
            $table->boolean('complete')->default(0);  // if paid = payable

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('payroll_id')->unsigned();
            $table->bigInteger('businessday_id')->nullable()->unsigned();
            $table->bigInteger('branch_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('payroll_id')->references('id')->on('payrolls');
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
        Schema::dropIfExists('salaries');
    }
}
