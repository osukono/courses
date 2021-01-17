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
            ],
            'topic_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('topics', 'id'),
            ],
            'title' => [
                'bail',
                'nullable',
                'string',
                'max:255'
            ],
        ];
    }
}
