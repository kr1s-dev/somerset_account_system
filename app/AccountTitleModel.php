<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountTitleModel extends Model
{
    /*
    **
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'account_titles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_sub_group_name',
                            'account_group_id',
                            'description',
                            'opening_balance',
                            'default_value',
                            'account_title_id',
                            'vat_percent',
                            'subject_to_vat'];

    public function group(){
        return $this->belongsTo('App\AccountGroupModel','account_group_id');
    }

    public function accountTitleParent(){
        return $this->belongsTo('App\AccountTitleModel','account_title_id');
    }

    public function accountTitleChildren(){
        return $this->hasMany('App\AccountTitleModel','account_title_id');
    }


}
