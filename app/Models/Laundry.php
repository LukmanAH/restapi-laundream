<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Laundry extends Model
{
    use HasFactory;

    const STATUS_UNVALIDATE = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 0;

    


    protected $fillable = [
        'user_id',
        'name',
        'banner',
        'address',
        'province',
        'city',
        'phone',
        'lat',
        'lng',
        'status',
        'condition'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function catalogs(): HasMany
    {
        return $this->hasMany(Catalog::class);
    }

    public function parfumes(): HasMany
    {
        return $this->hasMany(Parfume::class);
    }

    public function operationalHour(): HasMany
    {
        return $this->hasMany(OperationalHour::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function shippingRates(): HasMany
    {
        return $this->hasMany(ShippingRate::class);
    }

    public function scopeNearestTo(Builder $builder)
    {
        return $builder
            ->selectRaw("*,
            ( 6371 * acos( cos( radians(" . request('lat') . ") ) *
            cos( radians(lat) ) *
            cos( radians(lng) - radians(" . request('lng') . ") ) + 
            sin( radians(" . request('lat') . ") ) *
            sin( radians(lat) ) ) ) 
            AS distance")
            ->orderByRaw('distance');
    }
}
