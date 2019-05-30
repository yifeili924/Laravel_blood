<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function mcq()
    {
        return $this->belongsTo(Mcq::class);
    }
}
