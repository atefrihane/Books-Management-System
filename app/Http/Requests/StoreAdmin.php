<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdmin extends FormRequest
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
            '*.first_name' => 'required|max:90',
            '*.last_name' => 'required|max:90',
            '*.occupation' => 'nullable|integer|in:1,2',
            '*.institution' => 'nullable|max:90',
            '*.country' => 'nullable|max:90',
            '*.city' => 'nullable|max:90',
            '*.zipcode' => 'nullable|max:90',
            '*.city' => 'nullable|max:90',
            '*.address' => 'nullable|max:200',
            '*.phone' => 'nullable|digits:8|unique',
            '*.email' => 'required|email:rfc,dns|unique:users,email',
            '*.password' => 'required|max:90|confirmed',
            '*.recipient' => 'nullable|max:90',
            '*.phone_recipient' => 'nullable|digits:8',
        ];

    }

    public function messages()
    {
        return [
            '*.first_name.required' => 'Le prénom est requis',
            '*.first_name.max' => 'Le prénom est invalide',
            '*.last_name.required' => 'Le nom est requis',
            '*.last_name.max' => 'Le nom est requis',
            '*.occupation.integer' => 'L\'occupation est invalide',
            '*.occupation.in' => 'L\'occupation est invalide',
            '*.institution.max' => 'L\'institution est invalide',
            '*.country.max' => 'Pays est invalide',
            '*.city.max' => 'Ville est invalide',
            '*.first_name.required' => 'Le prénom est requis',
            '*.address.max' => 'Addresse invalide',
            '*.phone.digits' => 'Numéro de telephone est  invalide',
            '*.phone.unique' => 'Numéro de telephone déja existant',
            '*.email.required' => 'Email est requis', 
            '*.email.email' => 'Email est invalide', 
            '*.email.unique' => 'Email déja existant', 
            '*.password.required' => 'Mot de passe  est requis', 
            '*.password.max' => 'Mot de passe est invalide', 
            '*.password.confirmed' => 'Mot de passe est invalide', 
            '*.first_name.required' => 'Le prénom est requis',
            '*.recipient.max' => 'Le Récipient est invalide',
            '*.phone_recipient.digits' => 'Numéro de telephone du récipient est  invalide',
        ];
    }

}
