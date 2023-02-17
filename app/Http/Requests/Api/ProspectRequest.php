<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule,
    Illuminate\Validation\Rules\Password,
    Illuminate\Foundation\Http\FormRequest;

class ProspectRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'prospecting_mean_id' => ['required', 'int'],
            'email' => [
                        'required',
                        Rule::unique('prospects')->ignore($this->id)
                    ],
        ];
    }
}
