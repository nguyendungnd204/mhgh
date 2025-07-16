<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserCharacter extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'server_name', 'character_name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topupTransactions(): HasMany
    {
        return $this->hasMany(TopupTransaction::class);
    }
}
