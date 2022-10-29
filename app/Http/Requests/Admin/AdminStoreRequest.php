<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'                 => ['required', 'email', Rule::unique('users')],
            'name'                  => ['required'],
            'password'              => ['required', 'confirmed'],
            'no_hp'                 => ['required', 'digits_between:12,13'],
        ];
    }
}
