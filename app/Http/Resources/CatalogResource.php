<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CatalogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'laundry_id' => $this->laundry_id,
            'name' => $this->name,
            'icon' => $this->icon,
            'unit' => $this->unit,
            'price' => $this->price,
            'estimation_complete' => $this->estimation_complete,
            'estimation_type' => $this->estimation_type
        ];
    }
}
