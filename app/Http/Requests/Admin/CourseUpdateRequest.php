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
            'title' => ['bail', 'required', 'string', 'max:255'],
            'description' => ['bail', 'required', 'string', 'max:1500'],
            'android_product_id' => ['bail', 'nullable', 'string', 'max:255'],
            'ios_product_id' => ['bail', 'nullable', 'string', 'max:255'],
            'ad_mob_banner_unit_id_android' => ['bail', 'nullable', 'string', 'max:255'],
            'ad_mob_banner_unit_id_ios' => ['bail', 'nullable', 'string', 'max:255'],
            'demo_lessons' => ['bail', 'required', 'integer', 'min:0'],
            'version' => ['bail', 'required', 'integer', 'min:1'],
            'firebase_id' => ['bail', 'nullable', 'string', 'max:100'],
        ];
    }
}
