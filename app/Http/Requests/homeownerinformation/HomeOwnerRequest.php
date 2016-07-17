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
                return ['member_email_address' => 'required|email|max:255|unique:home_owner_information',
                        'member_gender' => 'required',];
            }
            //for update
            case 'PATCH':{  
                return['member_email_address' => 'required|email|max:255|unique:home_owner_information,member_email_address,' . $homeOwner->id];
            }
            //default
            default: break;
        }
    }
}
