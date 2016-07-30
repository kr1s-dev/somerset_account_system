<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetsModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'asset_items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['created_by',
    						'updated_by',
    						'account_title_id',
    						'quantity',
    						'reference',
    						'cost',
    						'monthly_depreciation',
    						'months_remaining',
    						'accumulated_depreciation',
    						'net_value'];

   	
}
