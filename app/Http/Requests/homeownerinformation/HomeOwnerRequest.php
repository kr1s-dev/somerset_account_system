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
                        'middle_name' => 'max:255',
                        'last_name' => 'required|min:3|max:255',
                        'member_occupation' => 'required|min:3|max:255',
                        'residence_tel_no' => 'required|numeric|digits_between:7,11|min:1',
                        'member_office_tel_no' => 'required|numeric|digits_between:7,11|min:1',
                        'member_mobile_no' => 'required|numeric|digits_between:11,13|min:1',
                        'member_date_of_birth' => 'required|before:today',
                        'member_address' => 'required|min:3|max:255',
                        'member_email_address' => 'required|email|max:255|unique:home_owner_information',
                        'member_gender' => 'required|min:3|max:255',
                        'block_lot_id'=>'required|unique:home_owner_information',];
            }
            //for update
            case 'PATCH':{  
                return['first_name' => 'required|min:3|max:255',
                        'middle_name' => 'max:255',
                        'last_name' => 'required|min:3|max:255',
                        'member_occupation' => 'required|min:3|max:255',
                        'residence_tel_no' => 'required|numeric|digits_between:7,11|min:1',
                        'member_office_tel_no' => 'required|numeric|digits_between:7,11|min:1',
                        'member_mobile_no' => 'required|numeric|digits_between:11,13|min:1',
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

    public function messages(){
        return ['first_name.required'=> $this->errMessage('required','First Name',null,null),
                'first_name.min'=>$this->errMessage('min','First Name',2,null),
                'first_name.max'=>$this->errMessage('max','First Name',255,null),
                'last_name.required'=> $this->errMessage('required','Last Name',null,null),
                'last_name.min'=>$this->errMessage('min','Last Name',2,null),
                'last_name.max'=>$this->errMessage('max','Last Name',255,null),
                'middle_name.max'=>$this->errMessage('max','Middle Name',255,null),
                'member_email_address.required'=>$this->errMessage('required','Email',null,null),
                'member_email_address.max'=>$this->errMessage('max','Email',255,null),
                'mobile_number.digits_between'=>$this->errMessage('digits_between','Mobile Number',null,'11 to 13'),];
    }

    public function errMessage($typeOfErr,$field,$charNum,$addMessage){
        if($typeOfErr=='required')
            return $field . ' is required';
        elseif ($typeOfErr=='min') {
            return $field . ' must be greater than '. $charNum .' characters';
        }elseif ($typeOfErr=='max') {
            return $field . ' must be less than '. $charNum .' characters';
        }elseif ('digits_between') {
            return $field . ' must be between '. $addMessage .' digits';
        }
    }
}
