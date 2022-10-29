<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'user'  => UserResource::make($this->whenLoaded('user')),
            'status' => $this->status
        ];
    }
}
