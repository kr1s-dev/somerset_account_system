<?php

namespace App\Http\Requests\accountTitle;

use App\Http\Requests\Request;
use App\AccountTitleModel;

class AccountTitleRequest extends Request
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
        $accountTitle = AccountTitleModel::find($this->accounttitle);
        switch($this->method())
        {
            case 'GET': break;
            case 'DELETE': break;
            //for insert
            case 'POST':{
                return ['account_sub_group_name' => 'unique:account_titles',
                            'account_group_id' => 'required',];
            }
            //for update
            case 'PATCH':{  
                return['account_sub_group_name' => 'unique:account_titles,account_sub_group_name,' . $accountTitle->id];
            }
            //default
            default: break;
        }
    }
}
