<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drinks', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('details')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('stock')->default(0);
            $table->bigInteger('count')->default(0);
            $table->bigInteger('crate_price')->nullable();
            $table->bigInteger('single_price')->nullable();

            $table->bigInteger('crate_size_id')->unsigned()->nullable();
            $table->bigInteger('drink_type_id')->unsigned()->nullable();
            $table->bigInteger('branch_id')->unsigned()->default(1);
            $table->bigInteger('creator_id')->unsigned()->nullable();

            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('crate_size_id')->references('id')->on('crate_sizes');
            $table->foreign('drink_type_id')->references('id')->on('drink_types');
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
        Schema::dropIfExists('drinks');
    }
}
