<?php

use App\Http\Services\StatsService;
use App\UserStat;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Created by PhpStorm.
 * User: kebler
 * Date: 10/10/18
 * Time: 21:19
 */

class UserStatsTest extends TestCase {

    use DatabaseMigrations;
    use RefreshDatabase;

    public function testUserStats()
    {
        //get user 1 to answers few questions.
        $choices = array(array("choice text 1"), array("choice text 2"), array("choice text 3", "on"), array("choice text 4"));
        $userId = 1;

        // correct
        StatsService::manageMcqStats($userId, 1, $choices, 2);

        // incorrect
        StatsService::manageMcqStats($userId, 2, $choices, 1);

        // incorrect
        StatsService::manageMcqStats($userId, 3, $choices, 3);

        // correct
        StatsService::manageMcqStats($userId, 4, $choices, 2);

        // incorrect
        StatsService::manageMcqStats($userId, 5, $choices, 1);

        //answer question 2 again correctly
        StatsService::manageMcqStats($userId, 2, $choices, 2);

        $user = UserStat::findById($userId);

        $answerStats = UserStat::getAnswerStats($user);

        $this->assertEquals(5, $answerStats["total"]);
        $this->assertEquals(5, $answerStats["mcqTotal"]);
        $this->assertEquals(0, $answerStats["emqTotal"]);
        $this->assertEquals(3, count($answerStats["mcqCorrect"]));
        $this->assertEquals(2, count($answerStats["mcqIncorrect"]));
        $this->assertEquals(true, $this->hasQuestionId($answerStats["mcqCorrect"], 1));
        $this->assertEquals(true, $this->hasQuestionId($answerStats["mcqCorrect"], 4));
        $this->assertEquals(true, $this->hasQuestionId($answerStats["mcqCorrect"], 2));

        $this->assertEquals(0, count($answerStats["emqCorrect"]));
        $this->assertEquals(0, count($answerStats["emqIncorrect"]));



        $stems = array(
            0 => array(0 => "answer text", 2 => array("choice 1"), 3 => array("choice 2"), 4 => array("choice 3","on")),
            2 => array(0 => "someother text", 2 => array("choice 1","on"), 3 => array("choice 2"), 4 => array("choice 3")),
            4 => array(0 => "someothertex", 2 => array("choice 1"), 3 => array("choice 2","on"), 4 => array("choice 3")));

        // 2 correct 1 inc
        $userAnswerIndex = array(0 => 4, 2 => 2, 4 => 4);
        $questionId = 1;
        $userId = 1;
        StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);


        // 1 correct 2 incorrect
        $userAnswerIndex = array(0 => 2, 2 => 3, 4 => 3);
        $questionId = 2;
        $userId = 1;
        StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        //question 1 again with 1 correct and 2 incorrect
        $userAnswerIndex = array(0 => 2, 2 => 2, 4 => 4);
        $questionId = 1;
        $userId = 1;

        StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        $user = UserStat::findById($userId);
        $answerStats = UserStat::getAnswerStats($user);

        //$this->assertEquals(6, count($user->emqAnswers));

        // assert stats.
        $this->assertEquals(11, $answerStats["total"]);
        $this->assertEquals(5, $answerStats["mcqTotal"]);
        $this->assertEquals(6, $answerStats["emqTotal"]);
        $this->assertEquals(3, count($answerStats["mcqCorrect"]));
        $this->assertEquals(2, count($answerStats["mcqIncorrect"]));
        $this->assertEquals(true, $this->hasQuestionId($answerStats["mcqCorrect"], 1));
        $this->assertEquals(true, $this->hasQuestionId($answerStats["mcqCorrect"], 4));
        $this->assertEquals(true, $this->hasQuestionId($answerStats["mcqCorrect"], 2));

        $this->assertEquals(2, count($answerStats["emqCorrect"]));
        $this->assertEquals(4, count($answerStats["emqIncorrect"]));


        UserStat::resetStats($userId);
        $user = UserStat::findById($userId);
        $answerStats = UserStat::getAnswerStats($user);
        $this->assertEquals(0, $answerStats["total"]);
        $this->assertEquals(0, $answerStats["mcqTotal"]);
        $this->assertEquals(0, $answerStats["emqTotal"]);
        $this->assertEquals(0, count($answerStats["mcqCorrect"]));
        $this->assertEquals(0, count($answerStats["mcqIncorrect"]));
        $this->assertEquals(0, count($answerStats["emqCorrect"]));
        $this->assertEquals(0, count($answerStats["emqIncorrect"]));

    }

    private function hasQuestionId($answers, $questionId) {
        foreach ($answers as $key => $answer) {
            if ($answer['question_id'] == $questionId) {
                return true;
            }
        }
        return false;
    }


    /*
     * We want the global stats to be based on the users' first answer while the user stats take the user's last
     * answers
     */
    public function testGlobalStatsTakeFirstUserAnswerButUserStatsTakeLastUserAnswer()
    {

        /* We have 5 users 4 MCQ1(a,b,c*),2(a,b*,c,d) and EMQ3,4 questions
         * first iteration:
         * user 1 answers MCQ1 (c)correctly
         * user 2 answers MCQ1 (a)incorrectly
         * user 3 answers MCQ1 (b)incorrectly
         * user 4 answers MCQ1 (c)correctly
         * user 5 answers MCQ1 (c)correctly
         *
         * This will yield global stats for MCQ1
         * (a) 20%
         * (b) 20%
         * (c) 60%
         *
         * user1 will have 1 user stats of:
         * total = 1
         * mcqTotal = 1
         * emqTotal = 0
         * mcqCorrect = 1
         * mcqIncorrect = 0
         * emqCorrect = 0
         * emqIncorrect = 0
         *
         * User 1 answers MCQ1 again (b)incorrectly: User stats should now change but global stats remain the same.
         * total = 1
         * mcqTotal = 1
         * emqTotal = 0
         * mcqCorrect = 0
         * mcqIncorrect = 1
         * emqCorrect = 0
         * emqIncorrect = 0
         */

        $mcq1Choices = array(array("choice text 1"), array("choice text 2"), array("choice text 3", "on"));
        // correct
                StatsService::manageMcqStats(1, 1, $mcq1Choices, 2);
                StatsService::manageMcqStats(2, 1, $mcq1Choices, 0);
                StatsService::manageMcqStats(3, 1, $mcq1Choices, 1);
                StatsService::manageMcqStats(4, 1, $mcq1Choices, 2);
        $stats= StatsService::manageMcqStats(5, 1, $mcq1Choices, 2);

        $this->assertEquals(5, $stats['total']);
        $this->assertEquals(20, $stats['stats'][0]);
        $this->assertEquals(20, $stats['stats'][1]);
        $this->assertEquals(60, $stats['stats'][2]);

        $user = UserStat::findById(1);
        $answerStats = UserStat::getAnswerStats($user);

        // assert user stats.
        $this->assertEquals(1, $answerStats["total"]);
        $this->assertEquals(1, $answerStats["mcqTotal"]);
        $this->assertEquals(0, $answerStats["emqTotal"]);
        $this->assertEquals(1, count($answerStats["mcqCorrect"]));
        $this->assertEquals(0, count($answerStats["mcqIncorrect"]));
        $this->assertEquals(0, count($answerStats["emqCorrect"]));
        $this->assertEquals(0, count($answerStats["emqIncorrect"]));

        // now user going to answer incorrectly
        $stats = StatsService::manageMcqStats(1, 1, $mcq1Choices, 0);

        // assert global stats remain the same
        $this->assertEquals(5, $stats['total']);
        $this->assertEquals(20, $stats['stats'][0]);
        $this->assertEquals(20, $stats['stats'][1]);
        $this->assertEquals(60, $stats['stats'][2]);

        $user = UserStat::findById(1);
        $answerStats = UserStat::getAnswerStats($user);
        //assert the user stats change.
        $this->assertEquals(1, $answerStats["total"]);
        $this->assertEquals(1, $answerStats["mcqTotal"]);
        $this->assertEquals(0, $answerStats["emqTotal"]);
        $this->assertEquals(0, count($answerStats["mcqCorrect"]));
        $this->assertEquals(1, count($answerStats["mcqIncorrect"]));
        $this->assertEquals(0, count($answerStats["emqCorrect"]));
        $this->assertEquals(0, count($answerStats["emqIncorrect"]));


        // user 1 answers an EMQ 1 stem correct 2 incorrect
        $stems = array(
            0 => array(0 => "answer text", 2 => array("choice 1"), 3 => array("choice 2"), 4 => array("choice 3","on")),
            2 => array(0 => "someother text", 2 => array("choice 1","on"), 3 => array("choice 2"), 4 => array("choice 3")),
            4 => array(0 => "someothertex", 2 => array("choice 1"), 3 => array("choice 2","on"), 4 => array("choice 3")));

        $userAnswerIndex = array(0 => 2, 2 => 2, 4 => 4);
        $questionId = 1;
        $userId = 1;
        $stats = StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        // global stats
        $this->assertEquals(1,      $stats['total']);
        $this->assertEquals(0,      $stats['stems'][0]['stemIndex']);
        $this->assertEquals(4,      $stats['stems'][0]['choiceIndex']);
        $this->assertEquals(2,      $stats['stems'][0]['userAnswerKey']);
        $this->assertEquals(0,      $stats['stems'][0]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][0]['isUserCorrect']);

        $this->assertEquals(2,      $stats['stems'][1]['stemIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['choiceIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['userAnswerKey']);
        $this->assertEquals(100,    $stats['stems'][1]['statCorrect']);
        $this->assertEquals(true,   $stats['stems'][1]['isUserCorrect']);

        $this->assertEquals(4,      $stats['stems'][2]['stemIndex']);
        $this->assertEquals(3,      $stats['stems'][2]['choiceIndex']);
        $this->assertEquals(4,      $stats['stems'][2]['userAnswerKey']);
        $this->assertEquals(0,      $stats['stems'][2]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][2]['isUserCorrect']);


        $user = UserStat::findById(1);
        $answerStats = UserStat::getAnswerStats($user);
        //assert the user stats change.
        $this->assertEquals(4, $answerStats["total"]);
        $this->assertEquals(1, $answerStats["mcqTotal"]);
        $this->assertEquals(3, $answerStats["emqTotal"]);
        $this->assertEquals(0, count($answerStats["mcqCorrect"]));
        $this->assertEquals(1, count($answerStats["mcqIncorrect"]));
        $this->assertEquals(1, count($answerStats["emqCorrect"]));
        $this->assertEquals(2, count($answerStats["emqIncorrect"]));



        // user 1 answers an EMQ 2 stem correct 1 incorrect
        $stems = array(
            0 => array(0 => "answer text", 2 => array("choice 1"), 3 => array("choice 2"), 4 => array("choice 3","on")),
            2 => array(0 => "someother text", 2 => array("choice 1","on"), 3 => array("choice 2"), 4 => array("choice 3")),
            4 => array(0 => "someothertex", 2 => array("choice 1"), 3 => array("choice 2","on"), 4 => array("choice 3")));

        $userAnswerIndex = array(0 => 4, 2 => 2, 4 => 4);
        $questionId = 1;
        $userId = 1;
        $stats = StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        // global stats
        $this->assertEquals(1,      $stats['total']);
        $this->assertEquals(0,      $stats['stems'][0]['stemIndex']);
        $this->assertEquals(4,      $stats['stems'][0]['choiceIndex']);
        $this->assertEquals(4,      $stats['stems'][0]['userAnswerKey']);
        $this->assertEquals(0,      $stats['stems'][0]['statCorrect']);
        $this->assertEquals(true,   $stats['stems'][0]['isUserCorrect']);

        $this->assertEquals(2,      $stats['stems'][1]['stemIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['choiceIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['userAnswerKey']);
        $this->assertEquals(100,  $stats['stems'][1]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][1]['isUserCorrect']);

        $this->assertEquals(4,      $stats['stems'][2]['stemIndex']);
        $this->assertEquals(3,      $stats['stems'][2]['choiceIndex']);
        $this->assertEquals(4,      $stats['stems'][2]['userAnswerKey']);
        $this->assertEquals(0,  $stats['stems'][2]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][2]['isUserCorrect']);


        $user = UserStat::findById(1);
        $answerStats = UserStat::getAnswerStats($user);
        //assert the user stats change.
        $this->assertEquals(4, $answerStats["total"]);
        $this->assertEquals(1, $answerStats["mcqTotal"]);
        $this->assertEquals(3, $answerStats["emqTotal"]);
        $this->assertEquals(0, count($answerStats["mcqCorrect"]));
        $this->assertEquals(1, count($answerStats["mcqIncorrect"]));
        $this->assertEquals(2, count($answerStats["emqCorrect"]));
        $this->assertEquals(1, count($answerStats["emqIncorrect"]));

    }
}