<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mcq extends Model
{
    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    /**
     * @param $qId
     * @param $choiceIndex
     * @param $userId
     */
    public static function saveAnswer($qId, $choiceIndex, $userId)
    {
        $question = self::findByQId($qId);
        $choice = $question->choices[$choiceIndex];
        $userStats = UserStat::findById($userId);
        //check if the user has already answered this question
        $existingAnswer = Answer::findByUserAndQid($qId, $userStats['id']);

        /*
         * there is not answers by this users,
         * the first 2 answers are one for 2 attempts first and last
         *
         */
        if (!isset($existingAnswer) || count($existingAnswer) == 0) {
            $answer = new Answer();
            $answer->question_id = $qId;
            $answer->userStat()->associate($userStats);
            $answer->choice()->associate($choice);
            $answer->first_attempt = true;
            $answer->save();

            $answer = new Answer();
            $answer->question_id = $qId;
            $answer->userStat()->associate($userStats);
            $answer->choice()->associate($choice);
            $answer->first_attempt = false;
            $answer->save();
        }  else if (count($existingAnswer) == 2) {
            foreach ($existingAnswer as $key => $answer) {
                if (!$answer->first_attempt) {
                    $answer->choice()->associate($choice);
                    $answer->save();
                }
            }
        } else {
            \Log::info("No more than 2 answers per user per MCQ allowed !");
        }




    }

    public static function findByQId($qId)
    {
        return self::where('qId', $qId)->first();
    }

    public static function findAll()
    {
        return self::orderBy('id', 'desc')->get();
    }

    public static function createMcq($qId)
    {
        $mcq = new Mcq();
        $mcq->qId = $qId;
        $mcq->save();
        return $mcq;
    }

    /**
     * @param $qId
     * @param $choices
     * @return array
     */
    public static function createQuestionAndAnswersIfNoneExist($qId, $choices)
    {
        $storedMcq = Mcq::findByQId($qId);
        if (!isset($storedMcq)) {
            $storedMcq = Mcq::createMcq($qId);
            // set choices if not set already
            if (!isset($storedMcq->choices) || count($storedMcq->choices) == 0) {
                foreach ($choices as $key => $val) {
                    $right = (isset($choices[$key][1])) ? true : false;
                    $choice = new Choice();
                    $choice->correct = $right;
                    $choice->choice = $key;
                    $choice->mcq()->associate($storedMcq);
                    $choice->save();
                    $storedMcq->choices()->save($choice);
                }
            }
        }
        return $storedMcq;
    }
}
