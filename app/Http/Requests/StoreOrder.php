<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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

            'user_id' => 'required|integer|exists:users,id',
            'products.*.product_id' => 'integer|required|exists:products,id',
            'products.*.price' => 'numeric|between:0,99.99|required',
            'products.*.type' => 'integer|required|in:1,2',
            'products.*.unit' => 'integer|required',
            'comment' => 'nullable|max:200'
        ];
    }
}
