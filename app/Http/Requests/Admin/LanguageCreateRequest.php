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
            'native' => [
                'bail',
                'string',
                'max:50',
            ],
            'code' => [
                'bail',
                'required',
                'string',
                'min:2',
                'max:12',
                Rule::unique('languages', 'code')
            ],
            'locale' => [
                'bail',
                'nullable',
                'string',
                'min:2',
                'max:12'
            ]
        ];
    }
}
