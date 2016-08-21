<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalEntryReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('journal_entry_reference')){
            Schema::create('journal_entry_reference', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->String('narration',255)->default('No Narration');
                $table->decimal('debit_total_amount',10,2)->default(0.00);
                $table->decimal('credit_total_amount',10,2)->default(0.00);
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
        //Drop Table of journal_entry if exist
        Schema::dropIfExists('journal_entry_reference');
    }
}
