<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmqAnswer extends Model
{
    //
    public static function findByUserAndQid($qId, $userId) {
        return self::where([
            ['question_id', '=',  $qId],
            ['user_stat_id', '=' ,$userId]
        ])->get();
    }

    public static function findAll()
    {
        return self::orderBy('id', 'desc')->get();
    }

    public function emqStem()
    {
        return $this->belongsTo(EmqStem::class);
    }

    public function userStat()
    {
        return $this->belongsTo(UserStat::class);
    }
}
