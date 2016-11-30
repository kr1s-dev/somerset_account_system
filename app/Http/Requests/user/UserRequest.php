<?php

namespace App\Http\Requests\user;

use App\User;
use App\Http\Requests\Request;

class UserRequest extends Request
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
        $user = User::find($this->users);
        switch($this->method())
        {
            case 'GET': break;
            case 'DELETE': break;
            //for insert
            case 'POST':{
                return ['first_name' => 'required|min:2|max:255',
                        'last_name' => 'required|min:2|max:255',
                        'email' => 'required|email|max:255|unique:users,email',
                        'mobile_number'=>'numeric|digits_between:11,13|min:1'];
            }
            //for update
            case 'PATCH':{
                return ['first_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$user->id,
                        'mobile_number'=>'numeric|digits_between:11,13|min:1'];

            }
            //default
            default: break;
        }
    }

    //Setting custom validation message
    public function messages(){
        return ['first_name.required'=>'First name is required',
                'first_name.min'=>'First name must be greater than 2 characters',
                'first_name.max'=>'First name must be less than 255 characters',
                'last_name.required'=>'Last name is required',
                'last_name.min'=>'Last name must be greater than 2 characters',
                'last_name.max'=>'Last name must be less than 255 characters',
                'email.max'=>'Email must be less than 255 characters',
                'mobile_number.digits_between'=>'Mobile Number must be between 11 to 13 digits',];
    }
}
