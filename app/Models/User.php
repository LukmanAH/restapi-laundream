<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_OWNER = 2;
    const ROLE_EMPLOYEE = 3;
    const ROLE_CUSTOMER = 4;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function laundry(): HasOne
    {
        return $this->hasOne(Laundry::class);
    }

    public function information(): HasMany
    {
        return $this->hasMany(information::class);
    }
}
