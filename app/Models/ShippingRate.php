<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingRate extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'laundry_id',
        'initial_km',
        'final_km',
        'price'
    ];

    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class);
    }
}
