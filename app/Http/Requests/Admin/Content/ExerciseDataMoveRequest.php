<?php

namespace App\Http\Requests\Admin\Content;

use App\ExerciseData;
use App\ExerciseField;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExerciseDataMoveRequest extends FormRequest
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
                Rule::exists('exercise_data')
            ],
            'index' => [
                'bail',
                'required',
                'integer',
                'min:1',
                'max:' . ExerciseData::findOrFail($this->get('id'))->maxSequence()
            ]
        ];
    }
}
