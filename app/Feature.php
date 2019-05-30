<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public function featuresets()
    {
        return $this->belongsToMany(Featureset::class);
    }
}
