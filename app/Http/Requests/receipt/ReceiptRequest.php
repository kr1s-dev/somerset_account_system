<?php

namespace App\Http\Requests\receipt;

use App\Http\Requests\Request;

class ReceiptRequest extends Request
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
        return ['receipt_no' => 'required|numeric|digits_between:7,15|unique:home_owner_payment_transaction|min:1',
                'amount_paid' => 'required|numeric|digits_between:1,10|min:1',];
    }
}
