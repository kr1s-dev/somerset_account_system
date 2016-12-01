<?php

namespace App\Http\Requests\homeownerInformation;

use App\HomeOwnerInformationModel;
use App\Http\Requests\Request;
use App\Http\Controllers\UtilityHelper;


class HomeOwnerRequest extends Request
{
    use UtilityHelper;
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
                        'residence_tel_no' => 'required|numeric|digits_between:7,11',
                        'member_office_tel_no' => 'required|numeric|digits_between:7,11',
                        'member_mobile_no' => 'required|numeric|digits_between:11,13',
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
                        'residence_tel_no' => 'required|numeric|digits_between:7,11',
                        'member_office_tel_no' => 'required|numeric|digits_between:7,11',
                        'member_mobile_no' => 'required|numeric|digits_between:11,13',
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
        return [$this->typeOfErr('required','first_name') =>$this->errMessage('required','Homeowner First Name',null,null),
                $this->typeOfErr('min','first_name')=>$this->errMessage('min','Homeowner First Name',2,null),
                $this->typeOfErr('max','first_name')=>$this->errMessage('max','Homeowner First Name',255,null),
                $this->typeOfErr('required','last_name')=> $this->errMessage('required','Homeowner Last Name',null,null),
                $this->typeOfErr('min','last_name')=>$this->errMessage('min','Homeowner Last Name',2,null),
                $this->typeOfErr('max','last_name')=>$this->errMessage('max','Homeowner Last Name',255,null),
                $this->typeOfErr('max','middle_name')=>$this->errMessage('max','Homeowner Middle Name',255,null),
                $this->typeOfErr('required','member_occupation')=>$this->errMessage('required','Homeowner Occupation',null,null),
                $this->typeOfErr('min','member_occupation')=>$this->errMessage('min','Homeowner Occupation',2,null),
                $this->typeOfErr('max','member_occupation')=>$this->errMessage('max','Homeowner Occupation',255,null),
                $this->typeOfErr('required','residence_tel_no')=>$this->errMessage('required','Homeowner Residence Tel. No.',null,null),
                $this->typeOfErr('digits_between','residence_tel_no')=>$this->errMessage('digits_between','Homeowner Residence Tel. No.',null,'7 to 11'),
                $this->typeOfErr('numeric','residence_tel_no')=>$this->errMessage('numeric','Homeowner Residence Tel. No.',null,null),
                $this->typeOfErr('required','member_office_tel_no')=>$this->errMessage('required','Homeowner Office Tel. No.',null,null),
                $this->typeOfErr('digits_between','member_office_tel_no')=>$this->errMessage('digits_between','Homeowner Office Tel. No.',null,'7 to 11'),
                $this->typeOfErr('numeric','member_office_tel_no')=>$this->errMessage('numeric','Homeowner Office Tel. No',null,null),
                $this->typeOfErr('required','member_mobile_no')=>$this->errMessage('required','Homeowner Mobile No',null,null),
                $this->typeOfErr('digits_between','member_mobile_no')=>$this->errMessage('digits_between','Homeowner Mobile No.',null,'11 to 13'),
                $this->typeOfErr('numeric','member_mobile_no')=>$this->errMessage('numeric','Homeowner Mobile No.',null,null),
                $this->typeOfErr('required','member_email_address')=>$this->errMessage('required','Homeowner Email',null,null),
                $this->typeOfErr('max','member_email_address')=>$this->errMessage('max','Homeowner Email',255,null),
                $this->typeOfErr('digits_between','mobile_number')=>$this->errMessage('digits_between','Mobile Number',null,'11 to 13'),];

    }

    
}
