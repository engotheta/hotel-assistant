<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('amount')->nullable();
            $table->bigInteger('quantity')->default(1);
            $table->bigInteger('total')->nullable();
            $table->string('details')->nullable();

            $table->bigInteger('transactionable_type'); // references the actual asset/expense
            $table->bigInteger('transactionable_id')->unsigned();

            $table->bigInteger('transactionType_id')->unsigned();
            $table->bigInteger('businessday_id')->unsigned();
            $table->bigInteger('department_id')->nullable()->unsigned();
            $table->bigInteger('activity_id')->nullable()->unsigned();
            $table->bigInteger('branch_id')->unsigned();

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
        Schema::dropIfExists('transactions');
    }
}
