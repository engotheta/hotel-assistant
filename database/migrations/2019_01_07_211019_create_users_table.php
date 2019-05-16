<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('gender');
            $table->date('birth')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('online')->default(1);
            $table->string('password')->default('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); //password
            $table->string('salary')->nullable();

            $table->bigInteger('branch_id')->unsigned();
            $table->bigInteger('role_id')->unsigned()->default(1);  //user
            $table->bigInteger('address_id')->unsigned()->nullable();
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->bigInteger('title_id')->unsigned()->nullable();
            $table->bigInteger('creator_id')->unsigned()->nullable();

            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('title_id')->references('id')->on('titles');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('department_id')->references('id')->on('departments');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

         $this-> seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }

    private function seed(){
        DB::table('users')->insert([
                 'name' =>'abraham',
                 'slug' =>'abraham',
                 'gender' =>'male',
                 'email' => 'ibranho@outlook.com',
                 'phone' => '+255657096681',
                 'role_id' => 3,
                 'branch_id' => 1,

             ]);
    }
}
