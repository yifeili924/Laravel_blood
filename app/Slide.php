<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    public $timestamps = false;

    public $totalFeatures = [];

    public function annotations()
    {
        return $this->hasMany(Annotation::class);
    }

    public function getPlainNameAttribute()
    {
        return basename($this->name, '.dzi');
    }

    public function morphology()
    {
        return $this->belongsTo(Morphology::class);
    }

    public function sample()
    {
        return $this->belongsTo(Sample::class);
    }

    public function mcase()
    {
        return $this->belongsTo(Mcase::class);
    }

    public function icase()
    {
        return $this->belongsTo(Icase::class);
    }

    public function featuresets()
    {
        return $this->hasMany(Featureset::class);
    }
}
