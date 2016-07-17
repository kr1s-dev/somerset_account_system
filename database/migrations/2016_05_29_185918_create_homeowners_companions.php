<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeownersCompanions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create home_owner_member_information Table in DB if it doesn't exist
        if(!Schema::hasTable('home_owner_member_information')){
            Schema::create('home_owner_member_information', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('home_owner_id')->unsigned();
                $table->foreign('home_owner_id')->references('id')->on('home_owner_information');
                $table->Integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->string('first_name',255);
                $table->string('last_name',255);
                $table->string('middle_name',255);
                $table->string('companion_occupation',255);
                $table->string('companion_office_tel_no',10);
                $table->string('companion_mobile_no',13);
                $table->string('companion_email_address',255);
                $table->string('relationship',255);
                $table->string('companion_gender',255);
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
        //Drop Table of home_owner_companion_information if exist
        Schema::dropIfExists('home_owner_member_information');
    }
}
