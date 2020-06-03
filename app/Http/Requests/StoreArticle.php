<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticle extends FormRequest
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
            'description' => 'required|max:200',
            'quotes' => 'required|max:2000',
            'writing_date' => 'required|date',
            'content' => 'required|max:1000000',
             'active' => 'required|in:0,1',
             'audio_link' => 'nullable|mimes:mpga,wav',
             'pdf_link' => 'nullable|mimes:pdf',
             'author_id' => 'required||exists:authors,id',
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
            '*.paper_price.between' => 'Le prix version papier est invalide',

        ];
    }
}
