<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopupTransaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'user_id',
        'server_name',
        'character_name',
        'card_type',
        'amount',
        'serial',
        'card_code',
        'status',
        'response_content',
        'submitted_at',
        'verified_at',
        'is_manual',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_manual' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

