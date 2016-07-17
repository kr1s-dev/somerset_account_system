<?php

/*
* @Author:      Kristopher N. Veraces
* @Description: Serves as model for User Type in Database
* @Date:        6/27/2016
*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTypeModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type',
                            'description'];


    
}
