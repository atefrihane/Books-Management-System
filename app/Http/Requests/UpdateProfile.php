<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
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
            'user_id'=>'required|exists:users,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'full_name' => 'nullable|max:200',
            'description' => 'nullable|max:500',
            'country' => 'nullable|max:200',
            'first_login' => 'nullable|in:0'
        
        ];

    }

}
