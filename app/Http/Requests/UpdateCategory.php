<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategory extends FormRequest
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
            'id' => 'required||exists:categories,id',
            'name' => 'required|unique:categories,name,NULL,id,deleted_at,NULL' . $this->id
        
          
        ];
    }
}
