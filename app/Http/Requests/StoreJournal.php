<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJournal extends FormRequest
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

        $this->request->get('journal');
        return [
            '*.photo' => 'required',
            '*.title' => 'required|max:200',
            '*.published_year' => 'required|digits:4',
            '*.director' => 'required|max:150',
            '*.editor' => 'required|max:90',
            '*.description' => 'required|max:500',

          
        ];

    }

    public function messages()
    {
        return [
            '*.photo.required' => 'La photo du livre est requise',
            '*.title.required' => 'Le titre est requis',
            '*.title.max' => 'Le titre est non valide',
            '*.published_year.digits' => 'L\'Année de publication est invalide',
            '*.editor.required' => 'L\'editeur est requis',
            '*.editor.max' => 'L\'editeur est invalide',
            '*.director.required' => 'Le directeur est requis',
            '*.director.max' => 'Le directeur est invalide',
            '*.description.required' => 'La description est requise',
            '*.description.max' => 'La description est invalide',
            
        ];
    }
}
