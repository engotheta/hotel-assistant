<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');  // formated 2019-12
            $table->string('slug');
            $table->integer('users');  // total number of people paid
            $table->bigInteger('amount')->nullable();  // total amount available for paid out
            $table->bigInteger('paid');  // total amount paid out
            $table->bigInteger('balance')->nullable();  // total amount carried forward

            $table->bigInteger('creator_id')->unsigned()->nullable();  // whose is doing the paying
            $table->bigInteger('branch_id')->unsigned();  // whose is doing the paying

            $table->foreign('creator_id')->references('id')->on('users');
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
        Schema::dropIfExists('payrolls');
    }
}
