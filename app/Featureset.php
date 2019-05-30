<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Featureset extends Model
{
    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    public function slide()
    {
        return $this->belongsTo(Slide::class);
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
