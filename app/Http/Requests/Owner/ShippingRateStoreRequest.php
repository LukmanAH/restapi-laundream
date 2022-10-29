<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRateStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->tokenCan('shipping.create');
    }

    public function rules()
    {
        return [
            'initial_km' => ['required'],
            'final_km' => ['required', 'gt:initial_km'],
            'price' => ['required']
        ];
    }
}
