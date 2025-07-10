<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    protected $fillable = ['image', 'content', 'order'];

    public function parent()
    {
        return $this->morphTo();
    }
}
