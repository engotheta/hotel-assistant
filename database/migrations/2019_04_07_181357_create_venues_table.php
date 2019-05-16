<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('details')->nullable();
            $table->bigInteger('weekday_price');
            $table->bigInteger('weekend_price');
            $table->bigInteger('floor')->default(0);
            $table->string('image')->nullable();
            $table->bigInteger('count')->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('fan')->default(true);
            $table->boolean('ac')->default(true);
            $table->bigInteger('capacity')->nullable();

            $table->bigInteger('branch_id')->unsigned()->default(1);
            $table->bigInteger('creator_id')->unsigned()->nullable();

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
        Schema::dropIfExists('venues');
    }
}
