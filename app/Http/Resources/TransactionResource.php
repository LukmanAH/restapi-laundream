<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'laundry' => LaundryResource::make($this->whenLoaded('laundry')),
            'catalog' => CatalogResource::make($this->whenLoaded('catalog')),
            'parfume' => ParfumeResource::make($this->whenLoaded('parfume')),
            'serial' => $this->serial,
            'amount' => $this->amount,
            'delivery_fee' => $this->delivery_fee?: 0 ,
            'distance' => number_format($this->distance,1),
            'service_type' => $this->service_type,
            'payment_type' => $this->payment_type,
            'address' => $this->address,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => $this->status,
            'additional_information_user' => $this->additional_information_user,
            'additional_information_laundry' => $this->additional_information_laundry,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-Y H:i')
        ];
    }
}
