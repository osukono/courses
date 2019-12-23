<?php

namespace App\Http\Requests\Admin\Content;

use App\Content;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContentCreateRequest extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'level_id.unique' => Content::withTrashed()->where('language_id', $this->get('language_id'))->where('level_id', $this->get('level_id'))->first() . ' already exists.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'language_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('languages', 'id')
            ],
            'level_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('levels', 'id'),
                Rule::unique('contents')->where('language_id', $this->get('language_id'))
            ],
        ];
    }
}
