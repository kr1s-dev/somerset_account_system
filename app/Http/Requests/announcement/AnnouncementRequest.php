<?php

namespace App\Http\Requests\announcement;

use App\Http\Requests\Request;

class AnnouncementRequest extends Request
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
                return ['headline' => 'required|min:10|max:255',
                        'message' => 'required|min:10|max:255',];
            }
            //for update
            case 'PATCH':{  
                return ['headline' => 'required|min:10|max:255',
                        'message' => 'required|min:10|max:255',];
            }
            //default
            default: break;
        }
    }
}
