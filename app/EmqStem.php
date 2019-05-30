<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmqStem extends Model
{
    public static function findById($emq_stem_id)
    {
        return self::where('id', $emq_stem_id)->first();
    }

    public function emq()
    {
        return $this->belongsTo(Emq::class);
    }

    public function emqAnswers()
    {
        return $this->hasMany(EmqAnswer::class);
    }
}
