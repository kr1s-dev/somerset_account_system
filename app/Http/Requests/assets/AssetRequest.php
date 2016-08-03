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
        switch($this->method())
        {
            case 'GET': break;
            case 'DELETE': break;
            //for insert
            case 'POST':{
                return ['account_title_id'=>'required',
                        'item_name'=>'required',
                        'description'=>'required',
                        'quantity'=>'required',
                        'total_cost'=>'required',
                        'salvage_value'=>'required',
                        'useful_life'=>'required',
                        'mode_of_acquisition'=>'required',
                        'interest' => 'required_if:mode_of_acquisition,Payable|required_if:mode_of_acquisition,Both',
                        'down_payment' => 'required_if:mode_of_acquisition,Both',];
            }
            //for update
            case 'PATCH':{  
                return ['account_title_id'=>'required',
                        'item_name'=>'required',
                        'description'=>'required',
                        'quantity'=>'required',
                        'total_cost'=>'required',
                        'salvage_value'=>'required',
                        'useful_life'=>'required',
                        'mode_of_acquisition'=>'required',
                        'interest' => 'required_if:mode_of_acquisition,Payable|required_if:mode_of_acquisition,Both',
                        'down_payment' => 'required_if:mode_of_acquisition,Both',];
            }
            //default
            default: break;
        }
    }
}
