<?php

use App\Http\Services\UtilsService;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: kebler
 * Date: 20/11/18
 * Time: 12:26
 */

class UserCommentsTest extends TestCase
{

    use DatabaseMigrations;


    public function testCommentsSubmitted()
    {
        // user 1 comments
        $userId = 1;
        $questionId = 1;
        $questionType = "mcq";
        $comment = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 
        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
         ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
          Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $type = "test";


        UtilsService::submitComment($userId, "userDetails", $questionId, $questionType, $comment, $type);


        // user 2 comments on the same question
        $userId = 2;
        $questionId = 1;
        $questionType = "mcq";
        UtilsService::submitComment($userId,"userDetails" ,$questionId, $questionType, $comment, $type);

        // user 1 comments on a different question
        $questionId = 1;
        $questionType = "essay";
        UtilsService::submitComment($userId, "userDetails", $questionId, $questionType, $comment, $type);

        $comments = UtilsService::getComments();

        $this->assertEquals(3, count($comments));

        $this->assertEquals($comment, $comments[0]->comment);

    }
}