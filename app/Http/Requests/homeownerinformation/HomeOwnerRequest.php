<?php

namespace App\Http\Requests\homeownerInformation;

use App\HomeOwnerInformationModel;
use App\Http\Requests\Request;

class HomeOwnerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $homeOwner = HomeOwnerInformationModel::find($this->homeowners);
        switch($this->method())
        {
            case 'GET': break;
            case 'DELETE': break;
            //for insert
            case 'POST':{
                return ['first_name' => 'required|min:3|max:255',
                        'middle_name' => 'required|min:3|max:255',
                        'last_name' => 'required|min:3|max:255',
                        'member_occupation' => 'required|min:3|max:255',
                        'residence_tel_no' => 'required|min:7|max:11',
                        'member_office_tel_no' => 'required|min:7|max:11',
                        'member_mobile_no' => 'required|min:11|max:13',
                        'member_date_of_birth' => 'required|before:today',
                        'member_address' => 'required|min:3|max:255',
                        'member_email_address' => 'required|email|max:255|unique:home_owner_information',
                        'member_gender' => 'required',
                        'block_lot_id'=>'required|unique:home_owner_information',];
            }
            //for update
            case 'PATCH':{  
                return['first_name' => 'required|min:3|max:255',
                        'middle_name' => 'required|min:3|max:255',
                        'last_name' => 'required|min:3|max:255',
                        'member_occupation' => 'required|min:3|max:255',
                        'residence_tel_no' => 'required|min:7|max:11',
                        'member_office_tel_no' => 'required|min:7|max:11',
                        'member_mobile_no' => 'required|min:11|max:13',
                        'member_date_of_birth' => 'required|date|before:today',
                        'member_address' => 'required|min:3|max:255',
                        'member_email_address' => 'required|email|max:255|unique:home_owner_information,member_email_address,' . $homeOwner->id,
                        'member_gender' => 'required',
                        'block_lot_id'=>'required|unique:home_owner_information,block_lot_id,'. $homeOwner->id,];
            }
            //default
            default: break;
        }
    }
}
