<?php

namespace App\Http\Requests\homeownermember;

use App\Http\Requests\Request;
use App\HomeOwnerMemberModel;

class HomeOwnerMemberRequest extends Request
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
        $homeownerMember = HomeOwnerMemberModel::find($this->homeownermembers);
        switch($this->method())
        {
            case 'GET': break;
            case 'DELETE': break;
            //for insert
            case 'POST':{
                return ['companion_gender' => 'required',
                        'first_name' => 'required|min:2|max:225',
                        'middle_name' => 'required|min:2|max:225',
                        'last_name' => 'required|min:2|max:225',
                        'companion_email_address' => 'email|max:255|unique:home_owner_member_information',
                        'companion_mobile_no' => 'numeric|digits_between:11,13|min:1',
                        'companion_occupation' => 'min:3|max:225',
                        'companion_office_tel_no' => 'numeric|digits_between:7,11|min:1',
                        'companion_date_of_birth' => 'required|before:today',
                        'home_owner_id'=>'required',
                        'relationship'=>'required|min:3|max:225',
                    ];
            }
            //for update
            case 'PATCH':{  
                return ['companion_gender' => 'required',
                        'first_name' => 'required|min:2|max:225',
                        'middle_name' => 'required|min:2|max:225',
                        'last_name' => 'required|min:2|max:225',
                        'companion_email_address' => 'email|max:255|unique:home_owner_member_information,companion_email_address,'. $homeownerMember->id,
                        'companion_mobile_no' => 'numeric|digits_between:11,13|min:1',
                        'companion_occupation' => 'min:3|max:225',
                        'companion_office_tel_no' => 'numeric|digits_between:7,11|min:1',
                        'companion_date_of_birth' => 'required|before:today',
                        'home_owner_id'=>'required',
                        'relationship'=>'required|min:3|max:225',
                        ];
            }
            //default
            default: break;
        }
        
    }
}
