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
                return ['first_name' => 'required|max:255',
                        'middle_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email',
                        'mobile_number'=>'numeric|digits_between:11,13|min:1'];
            }
            //for update
            case 'PATCH':{
                return ['first_name' => 'required|max:255',
                        'middle_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$user->id,
                        'mobile_number'=>'numeric|digits_between:11,13|min:1'];

            }
            //default
            default: break;
        }
    }
}
