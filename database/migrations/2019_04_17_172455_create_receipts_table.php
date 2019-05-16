<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('details')->nullable();
            $table->string('receiptient')->nullable();
            $table->bigInteger('receiptient_id')->nullable();   //if receiptient is a member

            $table->bigInteger('transaction_id')->unsigned();
            $table->bigInteger('branch_id')->unsigned();

            $table->foreign('transaction_id')->references('id')->on('transactions');
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
        Schema::dropIfExists('receipts');
    }
}
