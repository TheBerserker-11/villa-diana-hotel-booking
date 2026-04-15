<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'location',
        'avatar',
        'title',
        'insider_tip',
        'content',
        'rating',
        'stay_date'
    ];

    public function getAvatarUrlAttribute(): string
    {
        return MediaUrl::publicDisk($this->avatar);
    }
}
