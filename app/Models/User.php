<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_locked'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_locked' => 'boolean',
    ];

    /* ====== HELPERS ====== */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function lock(): void
    {
        $this->is_locked = true;
        $this->save();
    }

    public function unlock(): void
    {
        $this->is_locked = false;
        $this->save();
    }

    // Cập nhật password an toàn
    public function setPassword(string $password)
    {
        $this->password = Hash::make($password);
        $this->save();
    }
}
