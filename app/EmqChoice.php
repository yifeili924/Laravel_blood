<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmqChoice extends Model
{

    public function emq()
    {
        return $this->belongsTo(Emq::class);
    }
}
