<?php

namespace App\Http\Requests\vendor;

use App\Http\Requests\Request;
use App\VendorModel;

class VendorRequest extends Request
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
        $vendor = VendorModel::find($this->vendor);
        switch($this->method())
        {
            case 'GET': break;
            case 'DELETE': break;
            //for insert
            case 'POST':{
                return ['vendor_name' => 'required|min:3|max:255|unique:vendors',
                        'vendor_description' => 'required|min:3|max:255',
                        'vendor_contact_person' => 'required|min:3|max:255',
                        'vendor_telephone_no' => 'numeric|digits_between:7,11|min:1',
                        'vendor_mobile_no' => 'required|numeric|digits_between:11,13|min:1',
                        'vendor_email_address' => 'required|email|max:255|unique:vendors',];
            }
            //for update
            case 'PATCH':{  
                return ['vendor_name' => 'required|min:3|max:255|unique:vendors,vendor_name,' . $vendor->id,
                        'vendor_description' => 'required|min:3|max:255',
                        'vendor_contact_person' => 'required|min:3|max:255',
                        'vendor_telephone_no' => 'numeric|digits_between:7,11|min:1',
                        'vendor_mobile_no' => 'required|numeric|digits_between:11,13|min:1',
                        'vendor_email_address' => 'required|email|max:255|unique:vendors,vendor_email_address,' . $vendor->id,];
            }
            //default
            default: break;
        }
    }
}
