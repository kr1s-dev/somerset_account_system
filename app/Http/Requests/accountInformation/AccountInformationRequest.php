<?php

namespace App\Http\Requests\accountInformation;

use App\AccountDetailModel;
use App\Http\Requests\Request;

class AccountInformationRequest extends Request
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
        $accountDetail = AccountDetailModel::find($this->account);
        switch($this->method())
        {
            case 'GET': break;
            case 'DELETE': break;
            //for insert
            case 'POST':{
                return ['account_name' => 'unique:account_details',];
            }
            //for update
            case 'PATCH':{  
                return['account_name' => 'unique:account_details,account_name,' . $accountDetail->id];
            }
            //default
            default: break;
        }
    }
}
