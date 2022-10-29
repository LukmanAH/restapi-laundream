<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->tokenCan('employee.create');
    }

    public function rules()
    {
        return [
            'email'     => ['required', Rule::unique('users')],
            'name'      => ['required'],
            'no_hp'     => ['required']
        ];
    }
}
