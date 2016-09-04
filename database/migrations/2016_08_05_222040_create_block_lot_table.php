<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockLotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('block_lot')){
            Schema::create('block_lot', function (Blueprint $table) {
                $table->increments('id');
                $table->string('block_lot',255)->unique();
                $table->string('coordinates',255);
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
        Schema::dropIfExists('block_lot');
    }
}
