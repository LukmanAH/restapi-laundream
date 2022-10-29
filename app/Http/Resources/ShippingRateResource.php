<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingRateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'initial_km' => $this->initial_km,
            'final_km' => $this->final_km,
            'price' => $this->price
        ];
    }
}
