<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InformationResourceAdmin extends JsonResource
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
            'title'  => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'picture' => $this->picture,
            // 'created_by' => $this->whenLoaded('user')->name
        ];
    }
}
