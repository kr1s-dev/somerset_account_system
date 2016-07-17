    <?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('home_owner_invoice')){
            Schema::create('home_owner_invoice', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('home_owner_id')->unsigned();
                $table->foreign('home_owner_id')->references('id')->on('home_owner_information');
                $table->Integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->decimal('total_amount',10,2)->default(0.00);
                $table->Boolean('is_paid')->default(0);
                $table->timestamp('payment_due_date');

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
        //Drop Table of home_owner_invoice if exist
        Schema::dropIfExists('home_owner_invoice');
    }
}
