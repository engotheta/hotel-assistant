<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('picture');
            $table->string('details')->nullable();

            $table->string('picturable_type')->nullable(); // references the actual asset/expense/member/department/branch
            $table->bigInteger('picturable_id')->nullable()->unsigned();

            $table->bigInteger('uploader_id')->unsigned(); //uploader

            $table->foreign('uploader_id')->references('id')->on('users');

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
        Schema::dropIfExists('pictures');
    }
}
