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
        $asset = AssetsModel::find($this->assets);  
        $total_cost = $this->get('total_cost');
        switch($this->method())
        {
            case 'GET': break;
            case 'DELETE': break;
            //for insert
            case 'POST':{
                return ['account_title_id'=>'required',
                        'item_name'=>'required|min:3|max:255|unique:asset_items',
                        'description'=>'max:255',
                        'quantity'=>'required|numeric|digits_between:1,10|min:1',
                        'total_cost'=>'required|numeric|digits_between:1,10|min:1',
                        'salvage_value'=>'required|numeric|digits_between:1,10|min:1|max:'.($total_cost-1),
                        'useful_life'=>'required|numeric|digits_between:1,10|min:0',
                        'mode_of_acquisition'=>'required',
                        'down_payment' => 'required_if:mode_of_acquisition,Both|numeric|digits_between:1,10'];
            }
            //for update
            case 'PATCH':{  
                return ['account_title_id'=>'required',
                        'item_name'=>'required|min:3|max:255|unique:asset_items,item_name,'.$asset->id,
                        'description'=>'max:255',
                        'quantity'=>'required|numeric|digits_between:1,10|min:1',
                        'total_cost'=>'required|numeric|digits_between:1,10|min:1',
                        'salvage_value'=>'required|numeric|digits_between:1,10|min:1|max:'.($total_cost-1),
                        'useful_life'=>'required|numeric|digits_between:1,10|min:1',
                        'mode_of_acquisition'=>'required',
                        'down_payment' => 'required_if:mode_of_acquisition,Both|numeric|digits_between:1,10',];
            }
            //default
            default: break;
        }
    }
}
