<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OperationalHourResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'day' => $this->day,
            'open' => Carbon::parse($this->open)->format('h:i'),
            'close' => Carbon::parse($this->close)->format('h:i')
        ];
    }
}
