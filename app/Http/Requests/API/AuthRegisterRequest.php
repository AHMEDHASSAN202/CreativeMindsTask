<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
            'username'      => 'required|string|min:3|max:255',
            'mobile'        => 'required|string|min:4|max:13|unique:users',
            'password'      => 'required|string|min:6|max:255'
        ];
    }
}
