<?php

namespace App\Http\Requests\Api;

//use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|string|exists:users,email',
            'password' => [
                'required',
            ],
            'remember' => 'boolean'
        ];
    }

    /*
    public function failedValidation() {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'validation error',
            'errors' => $validator->errors()
        ]));
    }
    */

    protected function failedValidation(Validator $validator) {
        //throw new HttpResponseException(response()->json($validator->errors(), 422));

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'validation error',
            'errors' => $validator->errors(),
            'data' => [],
        ], 500));
    }
}
