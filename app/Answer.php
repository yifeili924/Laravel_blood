<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    public static function findByUserAndQid($qId, $userId) {
        return self::where([
            ['question_id', '=',  $qId],
            ['user_stat_id', '=' ,$userId]
        ])->get();
    }

    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }

    public function userStat()
    {
        return $this->belongsTo(UserStat::class);
    }
}
