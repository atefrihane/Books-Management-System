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
            'subject' => 'required|max:200',
            'why_to_read' => 'required|max:200',
            'quotes' => 'required|max:2000',
            'active' => 'required|in:0,1',
             'audio_link' => 'nullable|mimes:mpga,wav',
             'pdf_link' => 'nullable|mimes:pdf',
             'author_id' => 'required||exists:authors,id',
        ];

    }

 

  
}
