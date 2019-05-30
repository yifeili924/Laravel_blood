<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emq extends Model
{

    public static function saveAnswer($questionId, $userId, $userAnswerIndex)
    {

        $userStats = UserStat::findById($userId);
        // check if the user has answered the stems already
        $existingAnswer = EmqAnswer::findByUserAndQid($questionId, $userStats['id']);

        $question = Emq::findByQId($questionId);
        $stems = $question->emqStems;
        if (!isset($existingAnswer) || count($existingAnswer) == 0) {
            // not returned means its a fresh answer from a user, lets go.
            foreach ( $userAnswerIndex as $key => $val )
            {
                foreach ($stems as $key1 => $stem) {
                    if ($stem['stemIndex'] == $key) {
                        $answer = new EmqAnswer();
                        $answer->choiceIndex = $val;
                        $answer->question_id = $questionId;
                        $answer->emqStem()->associate($stem);
                        $answer->userStat()->associate($userStats);
                        $answer->first_attempt = true;
                        $answer->save();

                        $answer = new EmqAnswer();
                        $answer->choiceIndex = $val;
                        $answer->question_id = $questionId;
                        $answer->emqStem()->associate($stem);
                        $answer->userStat()->associate($userStats);
                        $answer->first_attempt = false;
                        $answer->save();
                    }
                }
            }

        }else {
            $lastAnswersIndex = $existingAnswer->filter(function ($answer) {
               return !$answer->first_attempt;
            });
            foreach ($userAnswerIndex as $key => $val) {
                foreach ($stems as $key1 => $stem) {
                    if ($stem['stemIndex'] == $key) {
                        foreach($lastAnswersIndex as $key => $answer){
                            if ($stem['id'] == $answer->emq_stem_id) {
                                $answer->choiceIndex = $val;
                                $answer->save();
                                break;
                            }
                        }
                    }
                }
            }
        }




    }

    public function emqChoices()
    {
        return $this->hasMany(EmqChoice::class);
    }

    public function emqStems()
    {
        return $this->hasMany(EmqStem::class);
    }

    public static function findByQId($qId)
    {
        return self::where('qId', $qId)->first();
    }

    private static function createEmq($qId)
    {
        $emq = new Emq();
        $emq->qId = $qId;
        $emq->save();
        return $emq;
    }

    public static function createEMQAndStemsIfNoneExist($qId, $stems)
    {
        $storedEmq = Emq::findByQId($qId);
        if (!isset($storedEmq)) {
            $storedEmq = Emq::createEmq($qId);
            // extract all choices first
            if (isset($stems[0])) {
                foreach ($stems[0] as $key => $choice) {
                    if ($key != 0) {
                        $newChoice = new EmqChoice();
                        $newChoice->index = $key;
                        $storedEmq->emqChoices()->save($newChoice);
                        $newChoice->emq()->associate($storedEmq);
                        $newChoice->save();
                    }
                }
            }

            foreach ($stems as $key => $stem) {
                foreach($stem as $key1 => $choice1){
                    if ($key1 != 0) {
                        if (count($choice1) == 2) {
                            $newStem = new EmqStem();
                            $newStem->choiceIndex = $key1;
                            $newStem->stemIndex = $key;
                            $storedEmq->emqStems()->save($newStem);
                            $newStem->emq()->associate($storedEmq);
                            $newStem->save();
                        }
                    }
                }
            }
        }
        $newEmq= Emq::findByQId($qId);
        return $storedEmq;
    }
}
