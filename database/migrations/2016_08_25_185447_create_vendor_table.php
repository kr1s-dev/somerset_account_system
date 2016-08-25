<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('vendors')){
            Schema::create('vendors', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->String('vendor_name',255)->unique();
                $table->String('vendor_description',255)->default('No Description');
                $table->String('vendor_mobile_no',255);
                $table->String('vendor_telephone_no',255);
                $table->String('vendor_email_address',255)->unique();
                $table->String('vendor_contact_person',255);
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
        //Drop Table of vendors if exist
        Schema::dropIfExists('vendors');
    }
}
