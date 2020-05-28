<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthor extends FormRequest
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
      
        $this->request->get('author');
        return [
            '*.photo' => 'required',
            '*.last_name' => 'required|max:150',
            '*.first_name' => 'required|max:150',
            '*.biography' => 'required|max:500',
        ];

    }

    public function messages()
    {
        return [
            '*.photo.required' => 'La photo du livre est requise',
            '*.last_name.required' => 'Le Nom est requis',
            '*.last_name.max' => 'Le Nom est invalide',
            '*.first_name.required' => 'Le prénom est requis',
            '*.first_name.max' => 'Le prénom est invalide',
            '*.biography.required' => 'La biographie est requis',
            '*.biography.max' => 'La biographie est invalide',

        ];
    }
}
