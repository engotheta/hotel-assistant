<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('details')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('stock')->default(0);
            $table->bigInteger('count')->default(0);

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
        Schema::dropIfExists('foods');
    }
}
