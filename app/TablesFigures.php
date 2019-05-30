<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TablesFigures extends Model
{
    protected $table = 'tablesfigures';
    public $timestamps = false;

    public function comments()
    {
        return $this->morphMany(\App\Models\Icomment::class, 'commentable')->whereNull('parent_id');
    }
}
