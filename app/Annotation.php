<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{

    public function slide()
    {
        return $this->belongsTo(Slide::class);
    }
}
