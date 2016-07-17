<?php
/*
* @Author:      Kristopher N. Veraces
* @Description: Serves as model for Receipt in Database
* @Date:        6/27/2016
*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'home_owner_payment_transaction';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['payment_id',
    						'paid_date',
                            'file_related'];

    public function invoice(){
        return $this->belongsTo('App\InvoiceModel','payment_id');
    }

    public function cashier(){
        return $this->belongsTo('App\User','created_by');
    }


}
