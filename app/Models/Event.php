<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'start_date',
        'end_date',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contentBlocks(): MorphMany
    {
        return $this->morphMany(ContentBlock::class, 'parent')->ordered();
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function getFormattedStartDateAttribute(): string
    {
        return $this->start_date->format('d/m/Y');
    }

    public function getFormattedEndDateAttribute(): string
    {
        return $this->end_date->format('d/m/Y');
    }

    public function getIsCurrentlyActiveAttribute(): bool
    {
        return $this->is_active && 
               $this->start_date <= now() && 
               $this->end_date >= now();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithinDates($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->where('start_date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('end_date', '<=', $endDate);
        }
        
        return $query;
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', '%' . $searchTerm . '%')
              ->orWhere('description', 'like', '%' . $searchTerm . '%');
        });
    }
}