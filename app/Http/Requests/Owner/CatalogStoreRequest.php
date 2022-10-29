<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class  CatalogStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->tokenCan('ownerDo');
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'icon' => ['required'],
            'unit' => ['required'],
            'price' => ['required', 'integer'],
            'estimation_complete' => ['required', 'integer'],
            'estimation_type' => ['required']
        ];
    }
}
