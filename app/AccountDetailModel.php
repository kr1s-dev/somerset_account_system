<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountDetailModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'account_details';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_name',
    						'accounting_year_start_date',
    						'accounting_year_end_date',
    						'o_p_balance',
                            'c_l_balance',
                            'c_l_balance_from_account_id'];
}
