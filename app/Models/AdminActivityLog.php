<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_user_id',
        'action',
        'target_type',
        'target_id',
        'details',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id', 'id');
    }

    public static function record(
        ?User $adminUser,
        string $action,
        ?string $targetType = null,
        int|string|null $targetId = null,
        array $details = []
    ): void {
        try {
            self::create([
                'admin_user_id' => $adminUser?->id,
                'action' => $action,
                'target_type' => $targetType,
                'target_id' => $targetId ? (string) $targetId : null,
                'details' => $details,
            ]);
        } catch (\Throwable $e) {
            // Ignore logging failures to avoid breaking critical admin actions.
        }
    }
}
