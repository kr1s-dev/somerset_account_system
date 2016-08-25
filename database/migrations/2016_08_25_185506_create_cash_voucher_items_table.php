<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashVoucherItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('expense_cash_voucher_items')){
            Schema::create('expense_cash_voucher_items', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('expense_cash_voucher_id')->unsigned();
                $table->foreign('expense_cash_voucher_id')->references('id')->on('expense_cash_voucher');
                $table->Integer('item_id')->unsigned();
                $table->foreign('item_id')->references('id')->on('invoice_expense_items');
                $table->Integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->decimal('amount',10,2)->default(0.00);
                $table->longText('remarks');
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
        //Drop Table of expense_cash_voucher_items if exist
        Schema::dropIfExists('expense_cash_voucher_items');
    }
}
