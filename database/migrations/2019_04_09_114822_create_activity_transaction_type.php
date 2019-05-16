<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTransactionType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('activity_transaction_type', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();

          $table->bigInteger('activity_id')->unsigned();
          $table->bigInteger('transaction_type_id')->unsigned();

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
        //
        Schema::dropIfExists('activity_transaction_type');
    }
}
