<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InformationStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'                 => ['required'],
            'description'           => ['required'],
            'picture'               => ['nullable', 'sometimes', 'mimes:jpg,jpeg,png']
        ];
    }
}
