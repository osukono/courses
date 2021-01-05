<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppLocaleCreateRequest extends FormRequest
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
            'key' => [
                'bail',
                'required',
                'string',
                'max:100',
                Rule::unique('app_locales', 'key')
            ],
            'description' => [
                'bail',
                'nullable',
                'string',
                'max:100'
            ],
            'locale_group_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('locale_groups', 'id')
            ],
            'locale' => [
                'bail',
                'required',
                'array'
            ],
            'locale.*' => [
                'bail',
                'nullable',
                'string',
                'max:500'
            ]
        ];
    }
}
