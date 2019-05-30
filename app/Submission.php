<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{

    public function icase()
    {
        return $this->belongsTo(Icase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function investigations()
    {
        return $this->belongsToMany(Investigation::class);
    }

    public function conclusions()
    {
        return $this->belongsToMany(Conclusion::class);
    }

    public function featuresets()
    {
        return $this->hasMany(Featureset::class);
    }
}
