<?php
/*
* @Author:      Kristopher N. Veraces
* @Description: Serves as model for Homeowner Information in Database
* @Date:        6/27/2016
*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeOwnerInformationModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'home_owner_information';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name',
    						'middle_name',
    						'last_name',
    						'member_occupation',
    						'residence_tel_no',
    						'member_office_tel_no',
    						'member_mobile_no',
    						'member_email_address',
    						'member_civil_status',
    						'member_gender',
    						'member_date_of_birth',
    						'member_active',
    						'member_address'];


    public function user(){
        return $this->hasOne('App\User','home_owner_id');
    }
}
