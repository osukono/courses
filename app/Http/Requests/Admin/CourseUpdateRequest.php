<?php

namespace App\Http\Requests\Admin;

use App\Library\Checkbox;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseUpdateRequest extends FormRequest
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
            'description' => ['bail', 'nullable', 'string', 'max:65535'],
            'demo_lessons' => ['bail', 'required', 'integer', 'min:0'],
            'price' => ['bail', 'required', 'numeric', 'min:0'],
            'published' => ['bail', 'nullable', Rule::in(Checkbox::$acceptable)],
        ];
    }
}
