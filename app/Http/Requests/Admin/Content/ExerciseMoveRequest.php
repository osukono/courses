<?php

namespace App\Http\Requests\Admin\Content;

use App\Exercise;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExerciseMoveRequest extends FormRequest
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
            'id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('exercises')
            ],
            'index' => [
                'bail',
                'required',
                'integer',
                'min:1',
                'max:' . Exercise::findOrFail($this->get('id'))->maxSequence()
            ]
        ];
    }
}
