<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class LaundryStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->tokenCan('customerDo');
    }

    public function rules()
    {
        return [
            'catalog_id' => ['required'],
            'parfume_id' => ['required'],
            'service_type' => ['required'],
            'payment_type' => ['required'],
            'address' => ['required'],
            'lat' => ['required', 'regex:/^(\+|-)?(?:90(?:(?:\.0{1,7})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,7})?))$/'],
            'lng' => ['required', 'regex:/^(\+|-)?(?:180(?:(?:\.0{1,7})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,7})?))$/'],
            'status' => ['required'],
            'additional_information_user' => ['nullable']
        ];
    }
}
