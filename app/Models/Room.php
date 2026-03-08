<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Room extends Model
{
    use HasFactory;

    public const EXTRA_PAX_FEE = 1200;

    protected $fillable = [
        'total_room',
        'no_beds',
        'price',         
        'image',
        'bed_type',
        'status',
        'desc',
        'room_type_id',
        'kuula_link',
        'included_pax',
        'max_capacity',
    ];

    
    protected $casts = [
        'status' => 'boolean',
    ];

   

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'room_id', 'id');
    }

    public function confirmedOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'room_id', 'id')
            ->where('status', 'confirmed');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function inclusions(): BelongsToMany
    {
        return $this->belongsToMany(Inclusion::class);
    }

   

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return asset('images/no-image.png');
        }

        $path = Str::startsWith($this->image, 'rooms/')
            ? $this->image
            : 'rooms/' . ltrim($this->image, '/');

        return asset('storage/' . $path);
    }

    public function getInclusionsAttribute()
    {
        return $this->roomType?->inclusions ?? collect();
    }

    public function getTourDetailsAttribute(): array
    {
        $desc = trim((string) ($this->desc ?? ''));

        $intro = $desc;
        $featuresText = '';
        $note = '';

        if (Str::contains($desc, 'Features:')) {
            $intro = trim(Str::before($desc, 'Features:'));
            $featuresText = trim(Str::after($desc, 'Features:'));
        }

        if (Str::contains($desc, 'IMPORTANT NOTE:')) {
            $note = trim(Str::after($desc, 'IMPORTANT NOTE:'));
            $featuresText = Str::contains($featuresText, 'IMPORTANT NOTE:')
                ? trim(Str::before($featuresText, 'IMPORTANT NOTE:'))
                : $featuresText;
        }

        $intro = str_replace('**', '', $intro);
        $featuresText = str_replace('**', '', $featuresText);
        $note = str_replace('**', '', $note);

        $allFeatures = collect(preg_split("/\r\n|\n|\r|,\s*/", $featuresText))
            ->map(fn ($item) => trim((string) $item))
            ->filter(fn ($item) => $item !== '' && !Str::startsWith(Str::upper($item), 'IMPORTANT NOTE'))
            ->values();

        $half = (int) ceil($allFeatures->count() / 2);

        return [
            'intro' => $intro,
            'room_highlights' => $allFeatures->slice(0, $half)->values()->all(),
            'comfort_amenities' => $allFeatures->slice($half)->values()->all(),
            'note' => $note,
        ];
    }

   

    public function includedPax(): int
    {
        if (Schema::hasColumn('rooms', 'included_pax')) {
            return max(1, (int) ($this->included_pax ?? 1));
        }
        return 1;
    }

    public function maxCapacity(): int
    {
        if (Schema::hasColumn('rooms', 'max_capacity')) {
            return max(1, (int) ($this->max_capacity ?? 2));
        }
        return 2;
    }

   
    public function computePerNightPrice(int $guests): array
    {
        $guests = max(1, $guests);

        $base = (float) ($this->price ?? 0);
        $included = $this->includedPax();

        $extraPax = max(0, $guests - $included);
        $perNight = $base + ($extraPax * self::EXTRA_PAX_FEE);

        return [$perNight, $extraPax];
    }

    public function computeTotalForStay(int $guests, string $checkIn, string $checkOut): array
    {
        [$perNight, $extraPax] = $this->computePerNightPrice($guests);

        $in = Carbon::parse($checkIn)->startOfDay();
        $out = Carbon::parse($checkOut)->startOfDay();
        $nights = max(1, $in->diffInDays($out));

        return [
            'per_night' => $perNight,
            'extra_pax' => $extraPax,
            'nights'    => $nights,
            'total'     => $perNight * $nights,
        ];
    }
}
