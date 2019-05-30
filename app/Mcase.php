<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mcase extends Model
{
    public $timestamps = false;

    public function slides()
    {
        return $this->hasMany(Slide::class);
    }

    public function comments()
    {
        return $this->morphMany(\App\Models\Icomment::class, 'commentable')->whereNull('parent_id');
    }
}
