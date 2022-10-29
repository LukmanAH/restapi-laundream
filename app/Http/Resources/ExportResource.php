<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ExportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'serial' => $this->serial,
            'customer' => $this->whenLoaded('user')->name,
            'layanan' => $this->whenLoaded('catalog')->name,
            'parfume' => $this->whenLoaded('parfume')->name,
            'tipe layanan' => $this->service_type == 1 ? 'Antar Sendiri' : 'Pickup-Delivery',
            'tipe pembayaran' => $this->payment_type == 1 ? 'Di Awal' : 'Di Akhir',
            'harga' => $this->amount,
            'ongkir' => $this->delivery_fee ?: 0,
            'alamat' => $this->address,
            'informasi tambahan customer' => $this->additional_information_user,
            'informasi tambahan laundry' => $this->additional_information_laundry,
        ];
    }
}
