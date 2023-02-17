<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProspectActivityRequest extends FormRequest
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
        /*
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
        ];
        */
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            /*
            'second_last_name',
            'client_medium_origin_id',

            'age',
            'rfc',
            'curp',
            'email',
            'gender',
            'extension',
            'birth_date',
            'phone_home',
            'profession',
            'birth_place',
            'phone_office',
            'phone_mobile',
            'service_priority',

            'city',
            'town',
            'state',
            'alias',
            'street',
            'indoor',
            'suburb',
            'outdoor',
            'country',
            'zipcode',

            ////Activity
            'comments',
            'user_id',
            'client_id',
            'activity_type_id',
            'activity_subject_id',

            'end_date',
            'start_date',
            'activity_date',
            'end_time',
            'start_time',
            */
        ];
    }
}
