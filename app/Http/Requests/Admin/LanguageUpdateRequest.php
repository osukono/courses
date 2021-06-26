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
            'native' => [
                'bail',
                'string',
                'max:50'
            ],
            'code' => [
                'bail',
                'required',
                'string',
                'min:2',
                'max:12',
                Rule::unique('languages', 'code')->ignore($this->language->id),
            ],
            'locale' => [
                'bail',
                'nullable',
                'string',
                'min:2',
                'max:12'
            ],
            'capitalized_words' => [
                'bail',
                'nullable',
                'string',
                'max:4096',
            ],
            'firebase_id' => [
                'bail',
                'nullable',
                'string',
                'max:255',
                Rule::unique('languages', 'firebase_id')->ignore($this->language->id),
            ],
        ];
    }
}
