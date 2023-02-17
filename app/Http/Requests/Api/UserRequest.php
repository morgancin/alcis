<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule,
    Illuminate\Validation\Rules\Password,
    Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'parent_id' => ['nullable', 'int'],
            'email' => [
                        'required',
                        Rule::unique('users')->ignore($this->id)
                    ],
            'password' => [
                            'required',
                            'confirmed',
                            Password::min(8)->mixedCase()->numbers()->symbols()
                        ],
        ];
    }
}
