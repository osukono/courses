<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PlayerSettingsRequest extends FormRequest
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
            'pause_after_exercise' => [
                'bail',
                'required',
                'numeric',
                'min:0',
            ],
            'pause_between' => [
                'bail',
                'required',
                'numeric',
                'min:0',
            ],
            'pause_practice_1' => [
                'bail',
                'required',
                'numeric',
                'min:0',
            ],
            'pause_practice_2' => [
                'bail',
                'required',
                'numeric',
                'min:0',
            ],
            'pause_practice_3' => [
                'bail',
                'required',
                'numeric',
                'min:0'
            ]
        ];
    }
}
