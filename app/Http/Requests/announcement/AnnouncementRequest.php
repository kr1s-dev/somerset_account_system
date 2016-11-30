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


    //Message
    public function messages(){
        return ['headline.required' => 'Announcement headline is required',
                'headline.min'=>'Announcement headline must be greater than 10 characters',
                'headline.max'=>'Announcement headline must be less than 255 characters',
                'message.required' => 'Announcement message is required',
                'message.min'=>'Announcement message must be greater than 10 characters',
                'message.max'=>'Announcement message must be less than 255 characters',
                ];
    }
}
