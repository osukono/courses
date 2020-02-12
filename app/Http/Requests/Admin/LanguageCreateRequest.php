<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LanguageCreateRequest extends FormRequest
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
            'name' => [
                'bail',
                'required',
                'string',
                'min:1',
                'max:50',
                Rule::unique('languages', 'name'),
            ],
            'code' => [
                'bail',
                'required',
                'string',
                'min:1',
                'max:12',
                Rule::unique('languages', 'code')
            ],
            'voice_name' => [
                'bail',
                'sometimes',
                'string',
                'max:255'
            ],
            'speaking_rate' => [
                'bail',
                'sometimes',
                'numeric',
                'min:0.25',
                'max:4.00'
            ],
            'pitch' => [
                'bail',
                'sometimes',
                'numeric',
                'min:-20.00',
                'max:20.00'
            ]
        ];
    }
}
