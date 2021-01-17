<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
                'max:100'
            ],
            'email' => [
                'bail',
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore(Auth::id())
            ],
            'old_password' => [
                'bail',
                'required',
                'string',
                'password'
            ],
        ];
    }
}
