<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseItemModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'expense_cash_voucher_items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['expense_cash_voucher_id',
    						'account_title_id',
    						'remarks',
    						'amount',
                            'created_by',
                            'updated_by'];

    public function accountTitle(){
        return $this->belongsTo('App\AccountTitleModel','account_title_id');
    }

    public function expense(){
        return $this->belongsTo('App\ExpenseModel','expense_cash_voucher_id');
    }

    public function userCreateInfo(){
        return $this->belongsTo('App\User','created_by');
    }

    public function userUpdateInfo(){
        return $this->belongsTo('App\User','updated_by');
    }
}
