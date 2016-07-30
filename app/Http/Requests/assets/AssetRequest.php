<?php

namespace App\Http\Requests\assets;

use App\Http\Requests\Request;
use App\AssetsModel;

class AssetRequest extends Request
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
        //$assets = $this->assets;
        $dateValidator = date('m/d/Y',strtotime('+2 day'));
        switch($this->method())
        {
            case 'GET': break;
            case 'DELETE': break;
            //for insert
            case 'POST':{
                return ['account_title_id'=>'required',
                        'item_name'=>'required',
                        'quantity'=>'required',
                        'description'=>'required',
                        'date_acquired'=>'required|before:'.$dateValidator,
                        'original_cost'=>'required',
                        'subject_to_depreciation'=>'required',
                        'monthly_depreciation' => 'required_if:subject_to_depreciation,Yes',];
            }
            //for update
            case 'PATCH':{  
                return ['account_title_id'=>'required',
                        'item_name'=>'required',
                        'quantity'=>'required',
                        'description'=>'required',
                        'date_acquired'=>'required|before:'.$dateValidator,
                        'original_cost'=>'required',
                        'subject_to_depreciation'=>'required',
                        'monthly_depreciation' => 'required_if:subject_to_depreciation,Yes',];
            }
            //default
            default: break;
        }
    }
}
