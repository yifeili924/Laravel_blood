<?php

use App\Http\Services\UtilsService;
use DrewM\MailChimp\MailChimp;

/**
 * Created by PhpStorm.
 * User: kebler
 * Date: 08/11/18
 * Time: 14:04
 */

class UtilTests extends TestCase {
    public function testBadChoiceIndicesFixer(){
        // lets make a corrupt choice index array
        $originalArray = [];
        $originalArray[0] = array("choice1", "on");
        $originalArray[2] = array("choice2");
        $originalArray[3] = array("choice3");
        $originalArray[4] = array("choice3");

        $this->assertEquals(true, UtilsService::isCorrupt($originalArray));
        $newArray = UtilsService::indexFixer($originalArray);
        $this->assertEquals(false, UtilsService::isCorrupt($newArray));


        $originalArray = [];
        $originalArray[0] = array("choice1", "on");
        $originalArray[1] = array("choice2");
        $originalArray[2] = array("choice3");
        $originalArray[3] = array("choice3");

        $this->assertEquals(false, UtilsService::isCorrupt($originalArray));
        $newArray = UtilsService::indexFixer($originalArray);
        $this->assertEquals(false, UtilsService::isCorrupt($newArray));


        $originalArray = [];
        $originalArray['0'] = array("choice1", "on");
        $originalArray['1'] = array("choice2");
        $originalArray['2'] = array("choice3");
        $originalArray['3'] = array("choice3");

        $this->assertEquals(false, UtilsService::isCorrupt($originalArray));
        $newArray = UtilsService::indexFixer($originalArray);
        $this->assertEquals(false, UtilsService::isCorrupt($newArray));


        $originalArray = [];
        $originalArray['0'] = array("choice1", "on");
        $originalArray['1'] = array("choice2");
        $originalArray['4'] = array("choice3");
        $originalArray['5'] = array("choice3");

        $this->assertEquals(true, UtilsService::isCorrupt($originalArray));
        $newArray = UtilsService::indexFixer($originalArray);
        $this->assertEquals(false, UtilsService::isCorrupt($newArray));


        $testArray = array(
            array("text"),
            array("text 2", "on"),
            array("tex 3"),
            array("text 4")
        );

        $this->assertEquals(false, UtilsService::isCorrupt($testArray));
    }


    public function testConvertNewEmqtoOldEmq() {

        $choices = array(
            0 => "choice 1",
            334 => "choice 2",
            222 => "choice 3",
            111 => "choice 4"
        );

        $newStems = array(
            0 => "new stem 1",
            515 => "new stem 2",
            154 => "new stem 3"
        );

        $selectedChoices = array(
            0 => "334",
            515 => "111",
            154 => "222"
        );

        $expectedStems = array(
            0 => array(0 => "new stem 1", 1 => array(1 => "choice 1"), 2 => array(1 => "choice 2", 2 => "on"), 3 => array(1 => "choice 3"), 4 => array(1=>"choice 4")),
            1 => array(0 => "new stem 2", 1 => array(1 => "choice 1"), 2 => array(1 => "choice 2"), 3 => array(1 => "choice 3"), 4 => array(1 =>"choice 4", 2 =>"on")),
            2 => array(0 => "new stem 3", 1 => array(1 =>"choice 1"), 2 => array(1 =>"choice 2"), 3 => array(1 =>"choice 3", 2 =>"on"), 4 => array(1 =>"choice 4"))
        );

        $this->assertDataStructure($expectedStems);

        $oldStems = UtilsService::formatNewEmqToOldEmq($choices, $newStems, $selectedChoices);

        $this->assertDataStructure($oldStems);


    }

    /**
     * @param $stems
     */
    public function assertDataStructure($stems)
    {
        $this->assertEquals(3, count($stems));
        $this->assertEquals(5, count($stems[0]));
        $this->assertEquals(5, count($stems[1]));
        $this->assertEquals(5, count($stems[2]));

        $this->assertEquals("new stem 1", $stems[0][0]);
        $this->assertEquals("choice 1", $stems[0][1][1]);
        $this->assertEquals("choice 2", $stems[0][2][1]);
        $this->assertEquals("on", $stems[0][2][2]);
        $this->assertEquals("choice 3", $stems[0][3][1]);
        $this->assertEquals("choice 4", $stems[0][4][1]);

        $this->assertEquals("new stem 2", $stems[1][0]);
        $this->assertEquals("choice 1", $stems[1][1][1]);
        $this->assertEquals("choice 2", $stems[1][2][1]);
        $this->assertEquals("choice 3", $stems[1][3][1]);
        $this->assertEquals("choice 4", $stems[1][4][1]);
        $this->assertEquals("on", $stems[1][4][2]);

        $this->assertEquals("new stem 3", $stems[2][0]);
        $this->assertEquals("choice 1", $stems[2][1][1]);
        $this->assertEquals("choice 2", $stems[2][2][1]);
        $this->assertEquals("choice 3", $stems[2][3][1]);
        $this->assertEquals("on", $stems[2][3][2]);
        $this->assertEquals("choice 4", $stems[2][4][1]);
    }

    public function testTrim()
    {
        $whiteSpaces = "helooworld.dzi";
        dd(basename($whiteSpaces, '.dzi'));
    }


    public function testAddSubscriber()
    {
        $list_id = env('MAILCHIMP_LIST');;
        $email = "abc.def@blood-academy.com";
        $first_name = "pishtyapi";
        $last_name = "aghaapi";
        $subscriptionType = 1;
        $response = UtilsService::addSubscriberToMC($list_id, $email, $first_name, $last_name, $subscriptionType);
        $this->assertEquals(true, true);
    }

    public function testUpdateSubscriber()
    {
        $list_id = env('MAILCHIMP_LIST');
        $email = "abc.def@blood-academy.com";
        $expire_at = date('m/d/Y', strtotime('+4 months'));
        $result = UtilsService::updateSubscriberMC($list_id, $email, $expire_at, 0);
        $this->assertEquals(true, true);
    }




    public function testMailChimpCampaignCreationAPI()
    {
        $list_id = 'a2650eceea';
        $notification_template_id = 119537;
        $welcomeTitle = "new_case";
        $icase_id = 2;

        $result = UtilsService::createMailChimpCampaign($icase_id, $welcomeTitle, $notification_template_id, $list_id);

        $this->assertEquals(true, isset($result));
    }

    private function sendCampaign($mc, $listId)
    {
        $result = $mc->post("campaigns", [
            'type' => "regular",
            'recipients' => [
                "list_id" => $listId
            ],
            'settings' => [
                "subject_line" => "New interactive case is published",
                "preview_text" => "New interactive case is published preview",
                "title" => "interactive case 1a",
                "from_name" => "BloodAcademy",
                "reply_to" => "admin@blood-academy.com",
                "to_name" => "*|FNAME|*",
                "template_id" => 119525
            ]
        ]);

        $this->assertEquals(true, isset($result));
        Log::info($result);

        $result = $mc->get("/campaigns/{$result['id']}/send-checklist");
        if ($result["is_ready"]) {
            Log::info("Campaign is ready to be scheduled");
            $result = $mc->post("/campaigns/{$result['id']}/actions/schedule", [
                ["schedule_time" => "2008-09-15T15:53:00"]
            ]);
        } else {
            Log::info("Campaign NO READY !!!!!!!______------");
        }


    }



    public function testGetListInfo()
    {

        $list_id = 'a2650eceea';
        $api_key = env('MAILCHIMP_APIKEY');
        try {
            $mc = new MailChimp($api_key);
            $result = $mc->get("lists/$list_id");
            dd($result);
        } catch (Exception $e) {
        }

    }

}