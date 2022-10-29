<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LaundryUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->tokenCan('laundry.update.status');
    }

    public function rules()
    {
        return [
            'status' => ['integer']
        ];
    }
}
