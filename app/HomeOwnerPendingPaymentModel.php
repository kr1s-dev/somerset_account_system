<?php
/*
* @Author:      Kristopher N. Veraces
* @Description: Serves as model for Invoice Items in Database
* @Date:        6/27/2016
*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeOwnerPendingPaymentModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'home_owner_invoice_items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['item_id',
    						'amount',
    						'created_by',
    						'invoice_id',
                            'remarks',
                            'updated_by'];

    public function item(){
        return $this->belongsTo('App\InvoiceExpenseItems','item_id');
    }

    public function invoice(){
        return $this->belongsTo('App\InvoiceModel','invoice_id');
    }
}
