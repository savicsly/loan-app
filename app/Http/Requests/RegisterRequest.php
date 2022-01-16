<?php

namespace App\Http\Requests;

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|unique:users',
            'phone' => 'nullable|unique:users',
            'gender' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'password' => 'required|min:6|confirmed',
            'user_type' => 'required'
        ];
    }

    public function messages()
    {
        return [];
    }
}
