<?php
namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image'
    ];


    public function images()
    {
        return $this->hasMany(EventImage::class);
    }

    public function getImageUrlAttribute(): string
    {
        return MediaUrl::publicDisk($this->image);
    }
}
