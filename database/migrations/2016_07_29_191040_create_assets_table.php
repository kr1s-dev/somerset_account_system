<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('asset_items')){
            Schema::create('asset_items', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->Integer('invoice_id')->unsigned()->nullable();
                $table->Integer('account_title_id')->unsigned();
                $table->foreign('account_title_id')->references('id')->on('account_titles');
                $table->Integer('quantity')->default(0);
                $table->String('reference',255);
                $table->Decimal('cost',10,2)->default(0);
                $table->Integer('months_remaining')->default(0);
                $table->Decimal('accumulated_depreciation',10,2)->default(0);
                $table->Decimal('net_value',10,2)->default(0);
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
        //Drop Table of asset_items if exist
        Schema::dropIfExists('asset_items');
    }
}
