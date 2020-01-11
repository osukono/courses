<?php

namespace App\Http\Requests\Admin;

use App\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** @property Language $language */
class LanguageUpdateRequest extends FormRequest
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
                Rule::unique('languages', 'name')->ignore($this->language->id),
            ],
            'code' => [
                'bail',
                'required',
                'string',
                'min:1',
                'max:12',
                Rule::unique('languages', 'code')->ignore($this->language->id),
            ]
        ];
    }
}
