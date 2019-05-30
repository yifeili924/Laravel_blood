<?php
/**
 * Created by PhpStorm.
 * User: kebler
 * Date: 31/08/18
 * Time: 17:23
 */
namespace App\Http\Services;
use App\Emq;
use App\Mcq;

class StatsService {

    public static function getMcqStats($questionId) {
        $question = Mcq::findByQId($questionId);
        $totalAnswers = 0;
        $result = array();
        foreach ($question->choices as $key => $choice) {
            $firstAnswers = $choice->answers->filter(function ($answer) {
                return $answer->first_attempt;
            });
            $numAns = count($firstAnswers);
            $totalAnswers += $numAns;
            array_push($result, $numAns);
        }
        $stats = array();
        foreach ($result as $key => $value) {
            array_push($stats, $totalAnswers > 0 ? round($value/$totalAnswers * 100) : 0);
        }

        return array(
            "total" => $totalAnswers,
            "stats" => $stats
        );
    }

    public static function manageMcqStats($userId, $questionId, $choices, $userAnswerIndex)
    {
        Mcq::createQuestionAndAnswersIfNoneExist($questionId, $choices);
        Mcq::saveAnswer($questionId, $userAnswerIndex, $userId);
        $stats = StatsService::getMcqStats($questionId);

        return $stats;
    }

    public static function manageEmqStats($userId, $questionId, $stems, $userAnswerIndex)
    {
        Emq::createEMQAndStemsIfNoneExist($questionId, $stems);
        Emq::saveAnswer($questionId, $userId, $userAnswerIndex);
        $stats = StatsService::getEmqStats($questionId);
        $finalStats = self::userFeedBack($stats, $userAnswerIndex);
        return $finalStats;
    }

    private static function userFeedBack($stats, $userAnswers) {
        foreach ($stats["stems"] as $key => $stem) {
            $userAnswer = $userAnswers[$stem["stemIndex"]];
            $stats['stems'][$key]['userAnswerKey'] = $userAnswer;
            if ($userAnswer == $stem['choiceIndex']) {
                $stats["stems"][$key]["isUserCorrect"] = true;
            } else {
                $stats["stems"][$key]["isUserCorrect"] = false;
            }
        }

        return $stats;
    }

    public static function getEmqStats($questionId)
    {
        $emq = Emq::findByQId($questionId);
        $stats = Array();
        $stems = Array();
        $tempAnswers = $emq->emqStems[0]->emqAnswers;
        $total = count($tempAnswers->filter(function ($answer){return $answer->first_attempt;}));
        foreach ($emq->emqStems as $key => $stem) {
            $correctAnswersCount = 0;

            $newStem['stemIndex'] = $stem['stemIndex'];
            $newStem['choiceIndex'] = $stem['choiceIndex'];

            $answers = $stem->EmqAnswers->filter(function ($answer) {
                return $answer->first_attempt;
            });
            foreach ($answers as $key1 => $answer) {
                //calculate the number of correct answers;
                if ($stem['choiceIndex'] == $answer['choiceIndex']) {
                    $correctAnswersCount++;
                }
            }
            $newStem["statCorrect"] = $total > 0 ? round($correctAnswersCount/$total * 100) : 0;
            array_push($stems, $newStem);
        }
        $stats["stems"] = $stems;
        $stats['total'] = $total;
        return $stats;
    }

    public static function deleteMcqEmqStats($type, $qId){
        switch ($type) {
            case "mcq":
                $mcq = Mcq::where("qId", $qId)->first();
                foreach ($mcq->choices as $key => $choice) {
                    $choice->answers()->delete();
                }
                $mcq->choices()->delete();
                $mcq->delete();
                break;
            case "emq":
                $emq = Emq::where("qId", $qId)->first();
                foreach ($emq->emqStems as $key1 => $stem) {
                    $stem->emqAnswers()->delete();
                }
                $emq->emqStems()->delete();
                $emq->emqChoices()->delete();
                break;
        }
    }
}