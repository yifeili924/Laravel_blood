<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Morphology extends Model
{
    protected $table = 'morphology';
    public $timestamps = false;

    public function slides() {
        return $this->hasMany(Slide::class);
    }
}
