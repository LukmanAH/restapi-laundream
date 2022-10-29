<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Information extends Model
{
    use HasFactory;

    protected $table = 'informations';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'picture'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
