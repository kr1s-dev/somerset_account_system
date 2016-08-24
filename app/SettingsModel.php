<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'system_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['created_by',
                            'updated_by',
                            'tax',
                            'days_till_due_date', 
                            'cut_off_date'];
    
}
