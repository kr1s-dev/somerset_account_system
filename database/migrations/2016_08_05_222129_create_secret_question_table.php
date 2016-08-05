<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecretQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('secret_question')){
            Schema::create('secret_question', function (Blueprint $table) {
                $table->increments('id');
                $table->string('secret_question',255)->unique();
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
        //Drop Table of secret_question if exist
        Schema::dropIfExists('secret_question');
    }
}
