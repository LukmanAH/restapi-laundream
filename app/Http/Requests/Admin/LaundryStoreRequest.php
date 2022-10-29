<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LaundryStoreRequest extends FormRequest
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
            'password_confirmation' => ['required'],
            'no_hp'                 => ['required', 'digits_between:12,13'],

            'laundry_name' => ['required'],
        ];
    }
}
