<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperationalHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'laundry_id',
        'day',
        'open',
        'close'
    ];

    protected $casts = [
        'open' => 'datetime:H:i',
        'close' => 'datetime:H:i',
    ];

    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class);
    }
}
