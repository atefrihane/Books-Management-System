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

        $this->request->get('book');
        return [
            '*.photo' => 'required',
            '*.title' => 'required|max:200',
            '*.published_year' => 'required|digits:4',
            '*.editor' => 'required|max:90',
            '*.count_pages' => 'required|integer|min:1',
            '*.isbn' => 'required|max:90',
            '*.description' => 'required|max:500',
            '*.active' => 'required|in:0,1',
            '*.height' => 'nullable|between:0,99.9999',
            '*.width' => 'nullable|between:0,99.9999',
            '*.thickness' => 'nullable||between:0,99.9999',
            '*.weight' => 'nullable|between:0,99.9999',
            '*.paper_price' => 'nullable|between:0,99.9999',
            '*.digital_price' => 'nullable|between:0,99.9999',
            '*.digital_link' => 'nullable',
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
            '*.count_pages.required' => 'Nombre des pages est requis',
            '*.count_pages.integer' => 'Nombre des pages est invalide',
            '*.count_pages.min' => 'Nombre des pages est invalide',
            '*.isbn.required' => 'ISBN est requis',
            '*.isbn.max' => 'ISBN est invalide',
            '*.description.required' => 'La description est requise',
            '*.description.max' => 'La description est invalide',
            '*.active.required' => 'L\'etat est requis',
            '*.active.in' => 'L\'etat est invalide',
            '*.height.required' => 'L\'hauteur est requis',
            '*.height.between' => 'L\'hauteur est invalide',
            '*.width.required' => 'Le largeur est requis',
            '*.width.between' => 'Le largeur est invalide',
            '*.thickness.required' => 'L\'epaisseur est requis',
            '*.thickness.between' => 'L\'epaisseur est invalide',
            '*.weight.required' => 'Le poids est requis',
            '*.weight.between' => 'Le poids est invalide',
            '*.paper_price.between' => 'Le prix version papier est invalide',
            '*.digital_price.between' => 'Le prix version numérique est invalide',
        ];
    }
}
