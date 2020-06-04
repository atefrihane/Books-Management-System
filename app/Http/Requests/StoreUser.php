<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'email' => 'bail|required|email:rfc,dns|unique:users,email',
            'first_name' => 'bail|required|max:90',
            'last_name' => 'bail|required|max:90',
            'password' => 'bail|required|confirmed|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:7168',
            
        ];

    }

}
