<?php

namespace App\Http\Requests\Admin;

use App\Topic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** @property Topic $topic */
class TopicUpdateRequest extends FormRequest
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
                'max:50',
                Rule::unique('topics', 'name')->ignore($this->topic->id),
            ],
            'identifier' => [
                'bail',
                'required',
                'string',
                'max:50',
                Rule::unique('topics', 'identifier')->ignore($this->topic->id),
            ],
            'firebase_id' => [
                'bail',
                'nullable',
                'string',
                'max:255',
                Rule::unique('topics', 'firebase_id')->ignore($this->topic->id),
            ]
        ];
    }
}
