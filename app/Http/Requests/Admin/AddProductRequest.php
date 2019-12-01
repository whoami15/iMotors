<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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

    public function rules()
    {
        return [
            'product_brand' => 'required',
            'brand_type' => 'required',
            'branch' => 'required',
            'title' => 'required',
            'description' => 'required',
            'stock' => 'required|numeric',
            'down_payment' => 'required',
            'price' => 'required',
            'payment_length' => 'required|numeric',
            'photos' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8000'
        ];
    }

}