<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Laundry;

class LaundryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
            $laundry = Laundry::query()
            ->with(['shippingRates'])
            ->where('id', $this->id)
            ->first();

            $operationalHour = json_decode($laundry
            ->operationalHour()
            ->where('day',Carbon::now()->isoFormat('dddd'))
            ->first());

            $open = strtotime(Carbon::now()->toDateString() . ' ' . $operationalHour->open); 
            
            $close = strtotime(Carbon::now()->toDateString() . ' ' . $operationalHour->close);

            $now = strtotime(Carbon::now()->toDateString() . ' ' . Carbon::now()->isoFormat('HH:mm')); 

            //return response()->json([$operationalHour, $open, $close, $now]);
            if($laundry->condition == 0){
                $cond = 0;
            }else if($open <= $now && $close >= $now){
                 $cond = 1;
             }else{
                 $cond = 0;
             }

        
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'catalogs' => CatalogResource::collection($this->whenLoaded('catalogs')),
            'parfumes' => ParfumeResource::collection($this->whenLoaded('parfumes')),
            'shippingRates' => ShippingRateResource::collection($this->whenLoaded('shippingRates')),
            'operationalHour' => OperationalHourResource::collection($this->whenLoaded('operationalHour')),
            'name'  => $this->name,
            'banner' => $this->banner,
            'address' => $this->address,
            'province' => $this->province,
            'city' => $this->city,
            'phone' => $this->phone,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => $this->status,
            'condition' => $cond,
            'distance' => number_format($this->distance, 2),
        ];
    }

}
