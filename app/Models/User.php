<?php

namespace App\Models;

use App\Models\Owner\Store;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'store_id', // Tambahkan store_id untuk admin/cashier
    ];

    // Relasi untuk owner (pemilik)
    public function stores()
    {
        return $this->hasMany(Store::class, 'owner_id');
    }

    // Relasi untuk admin dan cashier
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
