<?php

namespace App\Http\Requests\Dashboard;

use App\Repositories\AuthRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $user = $this->route('user');
        return [
            'username'      => 'nullable|string|min:3|max:255',
            'mobile'        => ['nullable', 'string', 'min:4', 'max:13', Rule::unique('users', 'mobile')->ignore($user->id)],
            'password'      => 'nullable|string|min:6|max:255'
        ];
    }
}
