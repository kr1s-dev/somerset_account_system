<?php

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
        //Create users Table in DB if it doesn't exist
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('home_owner_id')->unsigned()->nullable();
                $table->foreign('home_owner_id')->references('id')->on('home_owner_information');
                $table->Integer('user_type_id')->unsigned()->nullable();
                $table->foreign('user_type_id')->references('id')->on('user_type');
                $table->Integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned()->nullable();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->Integer('secret_question_id')->unsigned()->nullable();
                $table->foreign('secret_question_id')->references('id')->on('secret_question');
                $table->string('first_name',255)->nullable();
                $table->string('middle_name',255)->nullable();
                $table->string('last_name',255)->nullable();
                $table->string('email')->unique();
                $table->string('password', 60)->nullable();
                $table->string('mobile_number',255)->nullable();
                $table->boolean('is_active')->default(0);
                $table->string('confirmation_code')->nullable();
                $table->string('secret_answer', 60)->nullable();
                $table->rememberToken();
                $table->timestamps();

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop Table of home_owner_cars if exist
        Schema::dropIfExists('users');
    }
}
