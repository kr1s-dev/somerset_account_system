<?php

namespace App\Http\Requests\settings;

use App\Http\Requests\Request;

class SettingsRequest extends Request
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
        return ['tax' => 'required',
                'days_till_due_date' => 'required',
                'cut_off_date' => 'required'];
    }
}
