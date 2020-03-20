<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;

class ContentUpdateRequest extends FormRequest
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
            'title' => [
                'bail',
                'nullable',
                'string',
                'max:255'
            ],
            'description' => [
                'bail',
                'nullable',
                'string',
                'max:500'
            ],
            'player_version' => [
                'bail',
                'required',
                'integer',
                'min:0'
            ],
            'review_exercises' => [
                'bail',
                'required',
                'integer',
                'min:0'
            ]
        ];
    }
}
