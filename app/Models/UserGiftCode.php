<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserGiftCode extends Model
{
    protected $table = 'user_gift_codes';

    protected $fillable = [
        'user_id',
        'gift_code_id',
    ];

    /**
     * Quan hệ tới user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ tới gift code
     */
    public function giftCode(): BelongsTo
    {
        return $this->belongsTo(GiftCode::class);
    }
}
