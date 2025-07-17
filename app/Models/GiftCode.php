<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class GiftCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'reward',
        'expired_at',
        'max_uses',
        'used_count',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_gift_codes')
            ->withTimestamps();
    }

    public function isExpired(): bool
    {
        return $this->expired_at !== null && now()->greaterThanOrEqualTo($this->expired_at);
    }
}
