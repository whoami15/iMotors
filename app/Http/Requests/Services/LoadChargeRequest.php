<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class LoadChargeRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'mobile_number' => 'required',
            'promo' => 'required'
        ];
    }
}