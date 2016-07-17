<?php

namespace App\Http\Requests\homeownermember;

use App\Http\Requests\Request;

class HomeOwnerMemberRequest extends Request
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
        return [
            'companion_gender' => 'required',
        ];
    }
}
