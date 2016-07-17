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
    						'amount'];

    public function accountTitle(){
        return $this->belongsTo('App\AccountTitleModel','account_title_id');
    }
}
