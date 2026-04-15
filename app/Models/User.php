<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Support\MediaUrl;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'google_id',
        'auth_provider',
        'password',
        'phone',
        'address',
        'avatar',
        'is_admin',
        'email_verified_at',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function getAvatarUrlAttribute(): string
    {
        return MediaUrl::publicDisk($this->avatar);
    }
}
