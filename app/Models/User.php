<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'account_name',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function getRoleAttribute($value)
    {
        return $value ?? self::ROLE_USER;
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function topupTransactions(): HasMany
    {
        return $this->hasMany(TopupTransaction::class);
    }

    public function giftCodes(): BelongsToMany
    {
        return $this->belongsToMany(GiftCode::class, 'user_gift_codes')
            ->withTimestamps();
    }

    public function createdGiftCodes(): HasMany
    {
        return $this->hasMany(GiftCode::class, 'created_by');
    }

    public function characters(): HasMany
    {
        return $this->hasMany(UserCharacter::class);
    }


}
