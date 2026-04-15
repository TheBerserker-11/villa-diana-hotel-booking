<?php
namespace App\Models;

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
        if (!$this->image) {
            return '';
        }

        return route('media.show', ['path' => ltrim($this->image, '/\\')]);
    }
}
