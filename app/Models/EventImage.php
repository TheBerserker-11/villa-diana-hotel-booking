<?php
namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    use HasFactory;

    protected $fillable = ['event_id','image'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getImageUrlAttribute(): string
    {
        return MediaUrl::publicDisk($this->image);
    }
}
