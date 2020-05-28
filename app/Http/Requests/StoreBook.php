<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBook extends FormRequest
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
            'photo' => 'required',
            'title' => 'required|max:200',
            'published_year' => 'required|digits:4',
            'isbn' => 'required|max:90',
            'description' => 'required|max:500',
            'active' => 'required|in:0,1',
             'audio_link' => 'required|mimes:mpga,wav',
        ];

    }

 

  
}
