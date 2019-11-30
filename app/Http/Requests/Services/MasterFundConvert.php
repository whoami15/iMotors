<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class MasterFundConvert extends FormRequest
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
            'fund_type' => 'required',
            'amount' => 'required|numeric'
        ];
    }


    public function messages()
    {
        return [
            
        ];
    }
}
