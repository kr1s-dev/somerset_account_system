<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'home_owner_invoice';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_type_id',
    						'home_owner_id',
                            'total_amount',
                            'payment_due_date',
                            'invoice_id'];

    public function user(){
        return $this->belongsTo('App\User','created_by');
    }

    public function homeOwner(){
        return $this->belongsTo('App\HomeOwnerInformationModel','home_owner_id');
    }

    public function invoiceItems(){
        return $this->hasMany('App\HomeOwnerPendingPaymentModel','invoice_id');
    }

    public function receipt(){
        return $this->hasOne('App\ReceiptModel','payment_id');
    }

    public function penaltyInfo(){
        return $this->hasOne('App\InvoiceModel','invoice_id');
    }

    public function parentPenaltyInfo(){
        return $this->belongsTo('App\InvoiceModel','invoice_id');
    }
}
