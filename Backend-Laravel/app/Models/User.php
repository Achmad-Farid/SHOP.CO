<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email','password','phone','role',
    ];

    protected $hidden = [
        'password','remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi
    public function profile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultShippingAddress()
    {
        return $this->hasOne(Address::class)->where('is_default_shipping', true);
    }

    public function defaultBillingAddress()
    {
        return $this->hasOne(Address::class)->where('is_default_billing', true);
    }

    // Helper
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
