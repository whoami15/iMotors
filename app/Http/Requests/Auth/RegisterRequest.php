<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|alphaNum|max:255|unique:tbl_users,username',
            'email' => 'required|email|max:255|unique:tbl_users,email',
            'password' => 'required|alphaNum|confirmed|min:6|max:20',
            'last_name' => 'required|min:1|max:50',
            'middle_name' => 'required|min:1|max:50',
            'first_name' => 'required|min:1|max:50',
            'mobile' => 'required|numeric|min:11|unique:tbl_users,mobile',
            'gender'=> 'required|in:MALE,FEMALE',
            'birth_date' => 'required|date',
            'barangay' => 'required',
            'municipal' => 'required',
            'province' => 'required',
            'nearest_branch' => 'required|exists:tbl_branch,branch_name',
        ];
    }
}
