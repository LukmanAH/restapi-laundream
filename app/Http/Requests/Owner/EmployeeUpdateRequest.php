<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->tokenCan('employee.create');
    }

    public function rules()
    {
        return [
            'email'     => ['required', Rule::unique('users')->ignore($this->employee->user_id)],
            'name'      => ['required'],
            'no_hp'     => ['required']
        ];
    }
}
