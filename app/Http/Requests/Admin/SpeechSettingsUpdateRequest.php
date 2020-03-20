<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpeechSettingsUpdateRequest extends FormRequest
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
            'voice_name' => [
                'bail',
                'required',
                'string',
                'max:50'
            ],
            'sample_rate' => [
                'bail',
                'required',
                'integer',
                Rule::in([22050, 32000, 44100, 48000])
            ],
            'speaking_rate' => [
                'bail',
                'required',
                'numeric',
                'min:0.25',
                'max:4.0'
            ],
            'pitch' => [
                'bail',
                'required',
                'numeric',
                'min:-20.0',
                'max:20.0'
            ],
            'volume_gain_db' => [
                'bail',
                'required',
                'numeric',
                'min:-96.0',
                'max:16.0'
            ]
        ];
    }
}
