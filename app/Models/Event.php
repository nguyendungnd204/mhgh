<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'thumbnail',
        'start_date',
        'end_date',
        'created_by',
        'created_at',
        'update_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contentBlocks()
    {
        return $this->morphMany(ContentBlock::class, 'parent');
    }
}
