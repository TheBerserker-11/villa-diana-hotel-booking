<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomInclusion extends Model
{
    use HasFactory;

    protected $fillable = ['room_type_id', 'name'];

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

public function getIconAttribute()
{
    return match(strtolower($this->name)) {
        'wifi', 'free wifi', 'wi-fi' => 'fa-wifi',
        'breakfast', 'breakfast included' => 'fa-mug-hot',
        'aircon', 'air conditioning', 'ac' => 'fa-snowflake',
        'tv', 'smart tv' => 'fa-tv',
        'pool', 'swimming pool' => 'fa-person-swimming',
        'parking' => 'fa-square-parking',
        'hot shower', 'heater' => 'fa-shower',
        'mini bar', 'minibar' => 'fa-wine-bottle',
        default => 'fa-check-circle'
    };
}
}