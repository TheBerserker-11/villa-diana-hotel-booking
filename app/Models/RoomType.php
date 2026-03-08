<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RoomInclusion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'max_adults',
        'max_children',
        'max_infants',
        'pets_allowed',
        'inclusions'
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'room_type_id', 'id');
    }

    public function inclusions(): HasMany
    {
        return $this->hasMany(RoomInclusion::class);
    }
}