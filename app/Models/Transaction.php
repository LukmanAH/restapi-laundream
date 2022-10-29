<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    const STATUS_CONFIRM = 1;
    const STATUS_PICKUP = 2;
    const STATUS_QUEUE = 3;
    const STATUS_PROCESS = 4;
    const STATUS_READY = 5;
    const STATUS_DELIVER = 6;
    const STATUS_FINISHED = 7;

    const SERVICE_MANUAL = 1;
    const SERVICE_PICKUP = 2;

    const DELIVERY_EARLY = 1;
    const DELIVERY_FINISH = 2;

    protected $fillable = [
        'user_id',
        'laundry_id',
        'catalog_id',
        'parfume_id',
        'serial',
        'amount',
        'delivery_fee',
        'distance',
        'service_type',
        'payment_type',
        'address',
        'lat',
        'lng',
        'status',
        'additional_information_user',
        'additional_information_laundry'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class);
    }

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class);
    }

    public function parfume()
    {
        return $this->belongsTo(Parfume::class);
    }
}
