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
        return ['tax' => 'required|numeric|digits_between:1,10|min:1',
                'days_till_due_date' => 'required|numeric|digits_between:1,10|min:1|max:30',
                'cut_off_date' => 'required|numeric|digits_between:1,10|min:1|max:30'];
    }
}
