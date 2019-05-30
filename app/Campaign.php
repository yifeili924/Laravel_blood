<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{

    public function icase()
    {
        return $this->belongsTo(Icase::class);
    }
}
