<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    protected $fillable = [
        'parent_type',
        'parent_id', 
        'image', 
        'content', 
        'order'
    ];

    public function parent()
    {
        return $this->morphTo();
    }
}
