<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStat extends Model
{

    public static function resetStats($userId)
    {
        $user = UserStat::findById($userId);
        EmqAnswer::where('user_stat_id', $user['id'])->delete();
        Answer::where('user_stat_id', $user['id'])->delete();
        UserQuestion::where('user_id', $userId)->delete();
    }

    public function emqAnswers()
    {
        return $this->hasMany(EmqAnswer::class);
    }
    public function mcqAnswers()
    {
        return $this->hasMany(Answer::class);
    }


    public static function findById($userId)
    {
        $user = self::where('userId', $userId)->first();
        if (!isset($user)) {
            $user = new UserStat();
            $user->userId = $userId;
            $user->save();
        }
        return $user;
    }

    public static function getAnswerStats($user)
    {
        $emqAnswers = $user->emqAnswers->filter(function( $answer ){
            return !$answer->first_attempt;
        });
        $mcqAnswers = $user->mcqAnswers->filter(function( $answer ){
            return !$answer->first_attempt;
        });

        $result = Array();
        $countEmqs = isset($emqAnswers) ? count($emqAnswers) : 0;
        $countMcqs = isset($mcqAnswers) ? count($mcqAnswers) : 0;
        $result['total'] = $countEmqs + $countMcqs ;
        $result['mcqTotal'] = $countMcqs;
        $result['emqTotal'] = $countEmqs;
        $mcqStats = self::getMcqStats($mcqAnswers);
        $result['mcqCorrect'] = $mcqStats['mcqCorrect'];
        $result['mcqIncorrect'] = $mcqStats['mcqIncorrect'];

        $emqStats = self::getEmqStats($emqAnswers);
        $result['emqCorrect'] = $emqStats['emqCorrect'];
        $result['emqIncorrect'] = $emqStats['emqIncorrect'];

        return $result;
    }

    private static function getEmqStats($answers)
    {
        $correctAnswers = Array();
        $incorrectAnswers = Array();

        foreach ($answers as $key => $answer) {
            $isAnswerCorrect = $answer->emqStem['choiceIndex'] == $answer['choiceIndex'];
            if ($isAnswerCorrect) {
                array_push($correctAnswers, $answer);
            } else {
                array_push($incorrectAnswers, $answer);
            }
        }

        $result['emqCorrect'] = $correctAnswers;
        $result['emqIncorrect'] = $incorrectAnswers;

        return $result;
    }

    private static function getMcqStats($answers)
    {
        $correctAnswers = Array();
        $incorrectAnswers = Array();

        foreach ($answers as $key => $answer) {
            $choiceCorrect = $answer->choice['correct'];
            if ($choiceCorrect) {
                array_push($correctAnswers, $answer);
            } else {
                array_push($incorrectAnswers, $answer);
            }
        }

        $result['mcqCorrect'] = $correctAnswers;
        $result['mcqIncorrect'] = $incorrectAnswers;
        return $result;
    }
}
