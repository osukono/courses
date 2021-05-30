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
            'listening_rate' => [
                'bail',
                'required',
                'numeric',
                'min:0',
            ],
            'practice_rate' => [
                'bail',
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }
}
