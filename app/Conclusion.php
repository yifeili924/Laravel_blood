<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conclusion extends Model
{
    public function submissions()
    {
        return $this->belongsToMany(Submission::class);
    }
}
