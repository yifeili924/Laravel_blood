<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    public function slides() {
        return $this->hasMany(Slide::class);
    }
}
