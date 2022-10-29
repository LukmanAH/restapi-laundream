<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class LaundryUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'      => ['required'],
            'banner'    => ['mimes:jpeg,jpg,png', 'max:5000', 'nullable'],
            'lat'       => ['required', 'regex:/^(\+|-)?(?:90(?:(?:\.0{1,7})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,7})?))$/'],
            'lng'       => ['required', 'regex:/^(\+|-)?(?:180(?:(?:\.0{1,7})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,7})?))$/'],
            'address'   => ['required'],
            'province'  => ['required'],
            'city'      => ['required'],
            'phone'     => ['required'],
        ];
    }
}
