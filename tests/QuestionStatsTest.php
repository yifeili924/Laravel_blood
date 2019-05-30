<?php

use App\Answer;
use App\Choice;
use App\Emq;
use App\Http\Services\StatsService;
use App\Mcq;
use App\UserStat;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionStatsTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    //use DatabaseTransactions;


    public function testMcqManageStats()
    {

        $choices = array(array("choice text 1"), array("choice text 2"), array("choice text 3", "on"), array("choice text 4"));
        $questionId = 1;
        $userAnswerIndex = 2;
        $userId = 1;
        $stats = StatsService::manageMcqStats($userId, $questionId, $choices, $userAnswerIndex);

        $this->assertEquals(1, $stats['total']);
        $this->assertEquals(0, $stats['stats'][0]);
        $this->assertEquals(0, $stats['stats'][1]);
        $this->assertEquals(100, $stats['stats'][2]);
        $this->assertEquals(0, $stats['stats'][3]);

        //another user answers the same question incorrectly with choice 0 but gets stats because question is answered above
        $userId = 2;
        $userAnswerIndex = 0;

        $stats = StatsService::manageMcqStats($userId, $questionId, $choices, $userAnswerIndex);
        $this->assertEquals(2, $stats['total']);
        $this->assertEquals(50, $stats['stats'][0]);
        $this->assertEquals(0, $stats['stats'][1]);
        $this->assertEquals(50, $stats['stats'][2]);
        $this->assertEquals(0, $stats['stats'][3]);


        $userId = 3;
        $userAnswerIndex = 1;
        $stats = StatsService::manageMcqStats($userId, $questionId, $choices, $userAnswerIndex);
        $this->assertEquals(3, $stats['total']);
        $this->assertEquals(33, $stats['stats'][0]);
        $this->assertEquals(33, $stats['stats'][1]);
        $this->assertEquals(33, $stats['stats'][2]);
        $this->assertEquals(0, $stats['stats'][3]);


        $userId = 4;
        $userAnswerIndex = 3;
        $stats = StatsService::manageMcqStats($userId, $questionId, $choices, $userAnswerIndex);
        $this->assertEquals(4, $stats['total']);
        $this->assertEquals(25, $stats['stats'][0]);
        $this->assertEquals(25, $stats['stats'][1]);
        $this->assertEquals(25, $stats['stats'][2]);
        $this->assertEquals(25, $stats['stats'][3]);
    }

    public function testCreateQuestionIfOneDoesntExist()
    {
        $qId = 1;
        $mcq = Mcq::findByQId($qId);
        $isSet = isset($mcq) ? true: false;
        $this->assertEquals(false, $isSet);

        // create mock choices
        $choices = array(array("choice text 1"), array("choice text 2"), array("choice text 3", "on"), array("choice text 4"));
        Mcq::createQuestionAndAnswersIfNoneExist($qId, $choices);

        $mcq = Mcq::findByQId($qId);
        $isSet = isset($mcq) ? true: false;
        $this->assertEquals(true, $isSet);
        $this->assertEquals(4, count($mcq->choices));
        $this->assertEquals(false, $mcq->choices[0]['correct']);
        $this->assertEquals(true, $mcq->choices[2]['correct']);


        // if the create method is passed again it shouldnt make more choices
        Mcq::createQuestionAndAnswersIfNoneExist($qId, $choices);

        $mcq = Mcq::findByQId($qId);
        $isSet = isset($mcq) ? true: false;
        $this->assertEquals(true, $isSet);
        $this->assertEquals(4, count($mcq->choices));
        $this->assertEquals(false, $mcq->choices[0]['correct']);
        $this->assertEquals(true, $mcq->choices[2]['correct']);

    }

    public function testOneUserPerChoicePerQuestion()
    {
        $this->markTestSkipped("the test need modifying");

        // create question with choices
        $mcqQuestion = factory(Mcq::class)->create([
            'qId' => '1'
        ]);

        $choiceA = factory(Choice::class)->make([
            'choice' => '1',
            'correct' => true
        ]);

        $choiceB = factory(Choice::class)->make([
            'choice' => '2',
            'correct' => false
        ]);

        $choiceC = factory(Choice::class)->make([
            'choice' => '3',
            'correct' => false
        ]);

        $choiceD = factory(Choice::class)->make([
            'choice' => '4',
            'correct' => false
        ]);

        $mcqQuestion->choices()->save($choiceA);
        $mcqQuestion->choices()->save($choiceB);
        $mcqQuestion->choices()->save($choiceC);
        $mcqQuestion->choices()->save($choiceD);

        // save user id 1 first answer to question 1
        Mcq::saveAnswer(1, 0, 1);
        $createdQuestion = Mcq::findByQId($mcqQuestion['qId']);
        $firstCount = count($createdQuestion->choices[0]->answers);
        $this->assertEquals(1, $firstCount);

        // save user id 1 first answer to question 1 again
        Mcq::saveAnswer(1, 0, 1);
        $createdQuestion = Mcq::findByQId($mcqQuestion['qId']);
        $firstCount = count($createdQuestion->choices[0]->answers);
        $this->assertEquals(1, $firstCount);

        // user answers the same question with different choice
        Mcq::saveAnswer(1, 1, 1);
        $createdQuestion = Mcq::findByQId($mcqQuestion['qId']);
        $firstCount = count($createdQuestion->choices[1]->answers);
        $this->assertEquals(0, $firstCount);

        // user 2 answers same question with choice 1
        Mcq::saveAnswer(1, 0, 2);
        $createdQuestion = Mcq::findByQId($mcqQuestion['qId']);
        $firstCount = count($createdQuestion->choices[0]->answers);
        $this->assertEquals(2, $firstCount);

    }



    public function testStats()
    {
        $this->markTestSkipped('later aligator');
        $qId = 13;
        // create question and choices.
        $mcqQuestion = factory(Mcq::class)->create([
            'qId' => $qId
        ]);

        $choiceA = factory(Choice::class)->make([
            'choice' => 'a',
            'correct' => true
        ]);

        $choiceB = factory(Choice::class)->make([
            'choice' => 'b',
            'correct' => false
        ]);

        $choiceC = factory(Choice::class)->make([
            'choice' => 'c',
            'correct' => false
        ]);

        $choiceD = factory(Choice::class)->make([
            'choice' => 'd',
            'correct' => false
        ]);

        $mcqQuestion->choices()->save($choiceA);
        $mcqQuestion->choices()->save($choiceB);
        $mcqQuestion->choices()->save($choiceC);
        $mcqQuestion->choices()->save($choiceD);

        $createdQuestion = Mcq::findByQId($qId);
        $this->assertEquals(4, count($createdQuestion->choices));
        $this->assertEquals('a', $createdQuestion->choices[0]['choice']);

        // 4 users answer choice A from Question1
        factory(Answer::class)->create(
            [   'user_stat_id' => 1,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[0]['id']]);

        factory(Answer::class)->create(
            [   'user_stat_id' => 2,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[0]['id']]);

        factory(Answer::class)->create(
            [   'user_stat_id' => 3,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[0]['id']]);

        factory(Answer::class)->create(
            [   'user_stat_id' => 4,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[0]['id']]);


        // 3 users answer choice B from Question1
        factory(Answer::class)->create(
            [   'user_stat_id' => 5,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[1]['id']]);

        factory(Answer::class)->create(
            [   'user_stat_id' => 6,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[1]['id']]);

        factory(Answer::class)->create(
            [   'user_stat_id' => 7,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[1]['id']]);


        // 2 users answer choice c from Question1

        factory(Answer::class)->create(
            [   'user_stat_id' => 8,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[2]['id']]);

        factory(Answer::class)->create(
            [   'user_stat_id' => 9,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[2]['id']]);

        // 5 users answer choice A from Question1
        factory(Answer::class)->create(
            [   'user_stat_id' => 10,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[3]['id']]);

        factory(Answer::class)->create(
            [   'user_stat_id' => 11,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[3]['id']]);

        factory(Answer::class)->create(
            [   'user_stat_id' => 12,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[3]['id']]);

        factory(Answer::class)->create(
            [   'user_stat_id' => 13,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[3]['id']]);

        factory(Answer::class)->create(
            [   'user_stat_id' => 14,
                'question_id' => $qId,
                'choice_id' => $createdQuestion->choices[3]['id']]);


        $stats = StatsService::getMcqStats($mcqQuestion['qId']);

        $this->assertEquals(14, $stats['total']);
        $this->assertEquals(29, $stats['stats'][0]);
        $this->assertEquals(21, $stats['stats'][1]);
        $this->assertEquals(14, $stats['stats'][2]);
        $this->assertEquals(36, $stats['stats'][3]);

    }


    public function testCreateEmqAndAnswer()
    {
        $stems = array(
            0 => array(0 => "answer text", 2 => array("choice 1"), 3 => array("choice 2"), 4 => array("choice 3","on")),
            2 => array(0 => "someother text", 2 => array("choice 1","on"), 3 => array("choice 2"), 4 => array("choice 3")),
            4 => array(0 => "someothertex", 2 => array("choice 1"), 3 => array("choice 2","on"), 4 => array("choice 3")));

        $questionId = 1;
        $userAnswerIndex = array(0 => 2, 2 => 2, 4 => 4);
        Emq::createEMQAndStemsIfNoneExist($questionId, $stems);

        $emq = Emq::findByQId($questionId);
        $choices = $emq->choices;
        $this->assertEquals(3, count($choices));
        $savedStems = $emq->emqStems;
        $this->assertEquals(3, count($savedStems));
        $this->assertEquals(4, $savedStems[0]['choiceIndex']);
        $this->assertEquals(2, $savedStems[1]['choiceIndex']);
        $this->assertEquals(3, $savedStems[2]['choiceIndex']);

        //create again but it should remain the same
        Emq::createEMQAndStemsIfNoneExist($questionId, $stems);

        $emq = Emq::findByQId($questionId);
        $choices = $emq->choices;
        $this->assertEquals(3, count($choices));
        $savedStems = $emq->emqStems;
        \Log::info($savedStems);
        $this->assertEquals(3, count($savedStems));
        $this->assertEquals(4, $savedStems[0]['choiceIndex']);
        $this->assertEquals(2, $savedStems[1]['choiceIndex']);
        $this->assertEquals(3, $savedStems[2]['choiceIndex']);

        Emq::saveAnswer($questionId, "1", $userAnswerIndex);
        $emq2 = Emq::findByQId($questionId);
        $savedStems = $emq2->emqStems;

        $this->assertEquals(2, count($savedStems[0]->emqAnswers));
        $this->assertEquals(1, $savedStems[0]->emqAnswers[0]['user_stat_id']);
    }


    public function testManageEMQStats()
    {
        $stems = array(
            0 => array(0 => "answer text", 2 => array("choice 1"), 3 => array("choice 2"), 4 => array("choice 3","on")),
            2 => array(0 => "someother text", 2 => array("choice 1","on"), 3 => array("choice 2"), 4 => array("choice 3")),
            4 => array(0 => "someothertex", 2 => array("choice 1"), 3 => array("choice 2","on"), 4 => array("choice 3")));

        $userAnswerIndex = array(0 => 2, 2 => 2, 4 => 4);
        $questionId = 1;
        $userId = 1;
        $stats = StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        $this->assertEquals(1,      $stats['total']);

        $this->assertEquals(0,      $stats['stems'][0]['stemIndex']);
        $this->assertEquals(4,      $stats['stems'][0]['choiceIndex']);
        $this->assertEquals(0,  $stats['stems'][0]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][0]['isUserCorrect']);

        $this->assertEquals(2,      $stats['stems'][1]['stemIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['choiceIndex']);
        $this->assertEquals(100,  $stats['stems'][1]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][1]['isUserCorrect']);

        $this->assertEquals(4,      $stats['stems'][2]['stemIndex']);
        $this->assertEquals(3,      $stats['stems'][2]['choiceIndex']);
        $this->assertEquals(0,  $stats['stems'][2]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][2]['isUserCorrect']);

        // TODO the stats do change for user stats, modify test.
        // the same user answers the question again, only first answer is taken, stats dont change.
        $userId = 1;
        $userAnswerIndex = array(0 => 2, 2 => 2, 4 => 4);
        $stats = StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);
        $this->assertEquals(1,      $stats['total']);

        $this->assertEquals(0,      $stats['stems'][0]['stemIndex']);
        $this->assertEquals(4,      $stats['stems'][0]['choiceIndex']);
        $this->assertEquals(0,  $stats['stems'][0]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][0]['isUserCorrect']);

        $this->assertEquals(2,      $stats['stems'][1]['stemIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['choiceIndex']);
        $this->assertEquals(100,  $stats['stems'][1]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][1]['isUserCorrect']);

        $this->assertEquals(4,      $stats['stems'][2]['stemIndex']);
        $this->assertEquals(3,      $stats['stems'][2]['choiceIndex']);
        $this->assertEquals(0,  $stats['stems'][2]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][2]['isUserCorrect']);



        $userAnswerIndex = array(0 => 3, 2 => 3, 4 => 4);
        $userId = 2;
        $stats = StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        $this->assertEquals(2,      $stats['total']);

        $this->assertEquals(0,      $stats['stems'][0]['stemIndex']);
        $this->assertEquals(4,      $stats['stems'][0]['choiceIndex']);
        $this->assertEquals(0,  $stats['stems'][0]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][0]['isUserCorrect']);

        $this->assertEquals(2,      $stats['stems'][1]['stemIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['choiceIndex']);
        $this->assertEquals(50,  $stats['stems'][1]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][1]['isUserCorrect']);

        $this->assertEquals(4,      $stats['stems'][2]['stemIndex']);
        $this->assertEquals(3,      $stats['stems'][2]['choiceIndex']);
        $this->assertEquals(0,  $stats['stems'][2]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][2]['isUserCorrect']);


        $userAnswerIndex = array(0 => 4, 2 => 2, 4 => 3 );
        $userId = 3;
        $stats = StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        $this->assertEquals(3,      $stats['total']);

        $this->assertEquals(0,      $stats['stems'][0]['stemIndex']);
        $this->assertEquals(4,      $stats['stems'][0]['choiceIndex']);
        $this->assertEquals(33,  $stats['stems'][0]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][0]['isUserCorrect']);

        $this->assertEquals(2,      $stats['stems'][1]['stemIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['choiceIndex']);
        $this->assertEquals(67,  $stats['stems'][1]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][1]['isUserCorrect']);

        $this->assertEquals(4,      $stats['stems'][2]['stemIndex']);
        $this->assertEquals(3,      $stats['stems'][2]['choiceIndex']);
        $this->assertEquals(33,  $stats['stems'][2]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][2]['isUserCorrect']);


        $userAnswerIndex = array(0 => 4, 2 => 2, 4 => 3 );
        $userId = 4;
        $stats = StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        $this->assertEquals(4,      $stats['total']);

        $this->assertEquals(0,      $stats['stems'][0]['stemIndex']);
        $this->assertEquals(4,      $stats['stems'][0]['choiceIndex']);
        $this->assertEquals(50,  $stats['stems'][0]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][0]['isUserCorrect']);

        $this->assertEquals(2,      $stats['stems'][1]['stemIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['choiceIndex']);
        $this->assertEquals(75,  $stats['stems'][1]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][1]['isUserCorrect']);

        $this->assertEquals(4,      $stats['stems'][2]['stemIndex']);
        $this->assertEquals(3,      $stats['stems'][2]['choiceIndex']);
        $this->assertEquals(50,  $stats['stems'][2]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][2]['isUserCorrect']);

        $userAnswerIndex = array(0 => 2, 2 => 4, 4 => 4 );
        $userId = 5;
        $stats = StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        $this->assertEquals(5,      $stats['total']);

        $this->assertEquals(0,      $stats['stems'][0]['stemIndex']);
        $this->assertEquals(4,      $stats['stems'][0]['choiceIndex']);
        $this->assertEquals(40,  $stats['stems'][0]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][0]['isUserCorrect']);

        $this->assertEquals(2,      $stats['stems'][1]['stemIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['choiceIndex']);
        $this->assertEquals(60,  $stats['stems'][1]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][1]['isUserCorrect']);

        $this->assertEquals(4,      $stats['stems'][2]['stemIndex']);
        $this->assertEquals(3,      $stats['stems'][2]['choiceIndex']);
        $this->assertEquals(40,  $stats['stems'][2]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][2]['isUserCorrect']);


        // user 2 answers the same question again, stats shouldnt change as we only take the user's first answer.
        $userAnswerIndex = array(0 => 2, 2 => 2, 4 => 3 );
        $userId = 2;
        $stats = StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        $this->assertEquals(5,      $stats['total']);

        $this->assertEquals(0,      $stats['stems'][0]['stemIndex']);
        $this->assertEquals(4,      $stats['stems'][0]['choiceIndex']);
        $this->assertEquals(40,  $stats['stems'][0]['statCorrect']);
        $this->assertEquals(false,  $stats['stems'][0]['isUserCorrect']);

        $this->assertEquals(2,      $stats['stems'][1]['stemIndex']);
        $this->assertEquals(2,      $stats['stems'][1]['choiceIndex']);
        $this->assertEquals(60,  $stats['stems'][1]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][1]['isUserCorrect']);

        $this->assertEquals(4,      $stats['stems'][2]['stemIndex']);
        $this->assertEquals(3,      $stats['stems'][2]['choiceIndex']);
        $this->assertEquals(40,  $stats['stems'][2]['statCorrect']);
        $this->assertEquals(true,  $stats['stems'][2]['isUserCorrect']);
    }

    public function testEmqRelations()
    {
        $stems = array(
            0 => array(0 => "answer text", 2 => array("choice 1"), 3 => array("choice 2"), 4 => array("choice 3","on")),
            2 => array(0 => "someother text", 2 => array("choice 1","on"), 3 => array("choice 2"), 4 => array("choice 3")),
            4 => array(0 => "someothertex", 2 => array("choice 1"), 3 => array("choice 2","on"), 4 => array("choice 3")));

        $userAnswerIndex = array(0 => 2, 2 => 2, 4 => 4);
        $questionId = 1;
        $userId = 1;
        $stats = StatsService::manageEmqStats($userId, $questionId, $stems, $userAnswerIndex);

        $emq = Emq::where("qId", $questionId)->first();
        $this->assertEquals(3, count($emq->emqChoices));
        $this->assertEquals(3, count($emq->emqStems));
    }



    public function testWhenMCQEMQGetsDeletedStatsShouldReflect(){
        /*
         * 2 MCQs and 2 EMQs are created
         * User 1 answers MCQ1 with correctly and MCQ2 incorrectly
         * User 1 answers EMQ1 (2 stems correct, 1 incorrect)
         * User 1 answers EMQ2 (1 stem correct, 2 incorrect)
         * Initial user Stats should be
         * total:       8
         * mcqTotal:    2
         * emqTotal:    6
         * mcqCorrect:  1
         * mcqIncorrect:1
         * emqCorrect:  3
         * emqIncorrect:3
         *
         * Admin deletes MCQ 1 and EMQ 2
         * New user stats should be:
         * total:       4
         * mcqTotal:    1
         * emqTotal:    3
         * mcqCorrect:  0
         * mcqIncorrect:1
         * emqCorrect:  2
         * emqIncorrect:1
         *
         * *Also assert choices and answers are deleted*
         */

        $userId = 1;

        // MCQ 1
        $mcq1Choices = array(array("choice text 1"), array("choice text 2"), array("choice text 3", "on"));
        StatsService::manageMcqStats($userId, 1, $mcq1Choices, 2);

        // MCQ 2
        $mcq2Choices = array(array("choice text 1"), array("choice text 2", "on"), array("choice text 3"));
        StatsService::manageMcqStats($userId, 2, $mcq2Choices, 2);

        // EMQ 1
        $emq1Stems = array(
            0 => array(0 => "answer text", 2 => array("choice 1"), 3 => array("choice 2"), 4 => array("choice 3","on")),
            2 => array(0 => "someother text", 2 => array("choice 1","on"), 3 => array("choice 2"), 4 => array("choice 3")),
            4 => array(0 => "someothertex", 2 => array("choice 1"), 3 => array("choice 2","on"), 4 => array("choice 3")));

        $userAnswerIndex = array(0 => 4, 2 => 2, 4 => 4);
        StatsService::manageEmqStats($userId, 3, $emq1Stems, $userAnswerIndex);


        // EMQ 2
        $emq2Stems = array(
            0 => array(0 => "answer text", 2 => array("choice 1"), 3 => array("choice 2"), 4 => array("choice 3","on")),
            2 => array(0 => "someother text", 2 => array("choice 1","on"), 3 => array("choice 2"), 4 => array("choice 3")),
            4 => array(0 => "someothertex", 2 => array("choice 1"), 3 => array("choice 2","on"), 4 => array("choice 3")));

        $userAnswerIndex = array(0 => 4, 2 => 3, 4 => 4);
        StatsService::manageEmqStats($userId, 4, $emq2Stems, $userAnswerIndex);

        $user = UserStat::findById($userId);
        $answerStats = UserStat::getAnswerStats($user);

        $this->assertEquals(8, $answerStats["total"]);
        $this->assertEquals(2, $answerStats["mcqTotal"]);
        $this->assertEquals(6, $answerStats["emqTotal"]);
        $this->assertEquals(1, count($answerStats["mcqCorrect"]));
        $this->assertEquals(1, count($answerStats["mcqIncorrect"]));
        $this->assertEquals(3, count($answerStats["emqCorrect"]));
        $this->assertEquals(3, count($answerStats["emqIncorrect"]));

        // now lets delete and check the stats again.
        StatsService::deleteMcqEmqStats("mcq", 1);
        StatsService::deleteMcqEmqStats("emq", 4);

        $user = UserStat::findById($userId);
        $answerStats = UserStat::getAnswerStats($user);


        $this->assertEquals(4, $answerStats["total"]);
        $this->assertEquals(1, $answerStats["mcqTotal"]);
        $this->assertEquals(3, $answerStats["emqTotal"]);
        $this->assertEquals(0, count($answerStats["mcqCorrect"]));
        $this->assertEquals(1, count($answerStats["mcqIncorrect"]));
        $this->assertEquals(2, count($answerStats["emqCorrect"]));
        $this->assertEquals(1, count($answerStats["emqIncorrect"]));
    }
}
