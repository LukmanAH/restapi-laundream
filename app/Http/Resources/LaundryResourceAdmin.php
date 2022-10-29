<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaundryResourceAdmin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name'  => $this->name,
            'banner' => $this->banner,
            'address' => $this->address,
            'province' => $this->province,
            'city' => $this->city,
            'phone' => $this->phone,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => $this->status,
            'employe_count' => $this->employee_count,
            'transction_count' => $this->transaction_count,
            'owner' => UserResource::make($this->whenLoaded('user'))
        ];
    }
}
