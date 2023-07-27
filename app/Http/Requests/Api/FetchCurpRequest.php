<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FetchCurpRequest extends FormRequest
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
            'gender' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
            'last_name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'birth_place' => ['required', 'string'],
            'second_last_name' => ['required', 'string'],
        ];
    }
}
