<?php
/*
* @Author:      Kristopher N. Veraces
* @Description: Serves as model for Homeowner Members in Database
* @Date:        6/27/2016
*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeOwnerMemberModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'home_owner_member_information';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name',
    						'middle_name',
    						'last_name',
    						'companion_email_address',
    						'companion_mobile_no',
    						'companion_occupation',
    						'companion_office_tel_no',
    						'home_owner_id',
    						'relationship',
                            'companion_gender'];
}
