<?php

namespace App\Http\Requests\items;

use App\Http\Requests\Request;
use App\InvoiceExpenseItems;

class InvoiceExpenseItemsRequest extends Request
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
        $item = InvoiceExpenseItems::find($this->item);
        switch($this->method())
        {
            case 'GET': break;
            case 'DELETE': break;
            //for insert
            case 'POST':{
                return ['account_title_name' => 'required',
                        'item_name' => 'required|unique:invoice_expense_items',
                        'default_value' => 'required_if:subject_to_vat,on|numeric|digits_between:1,11|min:0',
                        'vat_percent' => 'required_if:subject_to_vat,on|numeric|digits_between:1,5',];
            }
            //for update
            case 'PATCH':{  
                return ['account_title_name' => 'required',
                        'item_name'=>'required|unique:invoice_expense_items,item_name,'.$item->id,
                        'default_value' => 'required_if:subject_to_vat,on|numeric|digits_between:1,11|min:0',
                        'vat_percent' => 'required_if:subject_to_vat,on|numeric|digits_between:1,5',];
            }
            //default
            default: break;
        }    
    }
}
