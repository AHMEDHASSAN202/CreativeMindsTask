<?php

namespace App\Http\Requests\API;

use App\Repositories\AuthRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
        $me = app(AuthRepository::class)->authUser();
        return [
            'username'      => 'sometimes|string|min:3|max:255',
            'mobile'        => ['sometimes', 'string', 'min:4', 'max:13', Rule::unique('users', 'mobile')->ignore($me->id)],
            'password'      => 'sometimes|string|min:6|max:255'
        ];
    }
}
