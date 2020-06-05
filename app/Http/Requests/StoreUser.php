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
            'email' => 'bail|required|email:rfc,dns|unique:users,email,NULL,id,deleted_at,NULL',
            'full_name' => 'bail|required|max:200',
             'password' => 'bail|required|confirmed|max:100',
     
            
        ];

    }

}
