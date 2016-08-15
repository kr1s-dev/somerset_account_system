<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'expense_cash_voucher';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_type_id',
    						'paid_to',
                            'total_amount',
                            'vendor_id'];

    public function user(){
        return $this->belongsTo('App\User','created_by');
    }
    
    public function expenseItems(){
        return $this->hasMany('App\ExpenseItemModel','expense_cash_voucher_id');
    }

    public function vendor(){
        return $this->belongsTo('App\VendorModel','vendor_id');
    }
}
