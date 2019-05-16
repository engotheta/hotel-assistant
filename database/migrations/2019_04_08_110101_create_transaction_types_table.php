<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->unique();
            $table->boolean('debit');  // decides where to add or subtract
            $table->boolean('for_all_services')->default(true);  //  available for all services
            $table->boolean('for_activities')->default(false);  //  available for the activies
            $table->boolean('prime')->default(false);  // occurs on daily basis
            $table->string('details')->nullable();

            $table->bigInteger('creator_id')->unsigned()->nullable();

            $table->foreign('creator_id')->references('id')->on('users');

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
        Schema::dropIfExists('transaction_types');
    }
}
