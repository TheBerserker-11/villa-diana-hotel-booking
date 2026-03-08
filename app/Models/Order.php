<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'check_in',
        'check_out',
        'room_id',

        // Guests
        'adults',
        'children',
        'infants',
        'pets',
        'total_guests',
        'extra_pax',
        'extra_pax_fee',

        // Reference + status
        'reference_code',
        'status',
        'cancel_reason',
        'proof_image',

        // Pricing
        'price_per_night',
        'sub_total',
        'vat_amount',
        'total_amount',
        'nights',
    ];

    protected $appends = [
        'stayDays',
        'computed_guests',
        'guest_total_label',
        'guest_breakdown',
        'guest_summary',
    ];

    protected $casts = [
        'check_in'  => 'datetime',
        'check_out' => 'datetime',
    ];

    

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

   

    public function getStayDaysAttribute(): int
    {
        if ($this->check_in && $this->check_out) {
            return $this->check_in->diffInDays($this->check_out);
        }

        return 0;
    }

    public function getComputedGuestsAttribute(): int
    {
        return (int) ($this->adults ?? 0)
            + (int) ($this->children ?? 0)
            + (int) ($this->infants ?? 0)
            + (int) ($this->pets ?? 0);
    }

    public function getGuestTotalLabelAttribute(): string
    {
        $total = $this->computed_guests;

        return $total . ' ' . Str::plural('guest', $total);
    }

    public function getGuestBreakdownAttribute(): string
    {
        $parts = [];

        $add = function (int $count, string $word) use (&$parts) {
            if ($count > 0) {
                $parts[] = $count . ' ' . Str::plural($word, $count);
            }
        };

        $add((int) ($this->adults ?? 0), 'Adult');
        $add((int) ($this->children ?? 0), 'Child');
        $add((int) ($this->infants ?? 0), 'Infant');
        $add((int) ($this->pets ?? 0), 'Pet');

        return implode(', ', $parts);
    }

    public function getGuestSummaryAttribute(): string
    {
        $breakdown = $this->guest_breakdown;

        return $breakdown === ''
            ? $this->guest_total_label
            : $this->guest_total_label . ' — ' . $breakdown;
    }
}