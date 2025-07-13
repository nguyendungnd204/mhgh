<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ContentBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_type',
        'parent_id',
        'content',
        'order',
        'image',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the parent model (Event, Article, etc.)
     */
    public function parent(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Scope to order blocks by their order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope to get blocks for a specific parent
     */
    public function scopeForParent($query, $parentType, $parentId)
    {
        return $query->where('parent_type', $parentType)
                    ->where('parent_id', $parentId);
    }
}