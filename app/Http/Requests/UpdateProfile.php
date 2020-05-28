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
            'first_name' => 'nullable|max:90',
            'last_name' => 'nullable|max:90',
            'occupation' => 'nullable|integer|in:1,2',
            'institution' => 'nullable|max:90',
            'country' => 'nullable|max:90',
            'city' => 'nullable|max:90',
            'zipcode' => 'nullable|max:90',
            'city' => 'nullable|max:90',
            'address' => 'nullable|max:200',
            'phone' => 'nullable|digits:8|unique:users,phone,' . $this->segment(3),
            'email' => 'nullable|email|unique:users,email,' . $this->segment(3),
            'password' => 'required_with:new_password|max:90',
            'new_password' => 'nullable|max:90|confirmed',
            'recipient' => 'nullable|max:90',
            'phone_recipient' => 'nullable|digits:8'

        ];

    }

}
