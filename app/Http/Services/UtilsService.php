<?php
/**
 * Created by PhpStorm.
 * User: kebler
 * Date: 08/11/18
 * Time: 14:21
 */

namespace App\Http\Services;


use App\Annotation;
use App\Comment;
use App\Conclusion;
use App\Essay;
use App\Feature;
use App\Haemothromb;
use App\Investigation;
use App\McqEmq;
use App\Morphology;
use App\QualityAssurance;
use App\Slide;
use App\Transfusion;
use App\UserTest;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use DrewM\MailChimp\MailChimp;
use Exception;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UtilsService
{

    /**
     * return true if the indices of the array arent incremental by +1 from 0 ie.
     * if the indices are 0,2,3,5, then it returns true.
     * @param $choices
     * @return bool
     */
    public static function isCorrupt($choices)
    {
        $correctIndex = -1;
        $corrupt = false;
        foreach ($choices as $key => $choice) {
            $correctIndex++;
            if ($correctIndex != $key) {
                $corrupt = true;
                break;
            }
        }
        return $corrupt;
    }

    /**
     * it takes a corrupt array and return an array with correct indecies ie. 0,1,2,3 etc
     * @param $choices
     * @return array
     */
    public static function indexFixer($choices){
        $newArray = [];
        foreach ($choices as $key => $choice) {
            array_push($newArray, $choice);
        }
        return $newArray;
    }

    public static function formatNewEmqToOldEmq(array $choices, array $newStems, array $selectedChoices) {
        $stems = [];

        $realIndex  = -1;
        foreach ($newStems as $key => $stemText) {
            $realIndex++;
            $stemArray = [];
            array_push($stemArray, $stemText);
            foreach ($choices as $key1 => $choice) {
                if ($selectedChoices[$key] == $key1) {
                    array_push($stemArray, array( 1 => $choice, 2 => "on"));
                } else {
                    array_push($stemArray, array( 1 => $choice));
                }
            }
            array_push($stems, $stemArray);
        }
        return $stems;
    }

    public static function submitComment($user_id, $userDetails, $questionId, $questionType, $comment, $commentType)
    {
        $newComment = new Comment();
        $newComment->user_id = $user_id;
        $newComment->user_details = $userDetails;
        $newComment->question_type = $questionType;
        $newComment->question_id = $questionId;
        $newComment->comment = $comment;
        $newComment->type = $commentType;
        $newComment->save();
    }

    public static function getComments()
    {
        return Comment::orderBy('created_at', 'des')->get();
    }

    /**
     * @param Request $request
     * @param $qtype
     * @param $qid
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public static function getQuestionByTypeAndId($qtype, $qid)
    {
        $model = null;
        $viewName = null;

        switch ($qtype) {
            case $qtype == "mcq":
                $model = new McqEmq();
                $viewName = 'panels.user.test-page-mcq';
                break;
            case $qtype == "morph":
                $model = new Morphology();
                $viewName = 'panels.user.test-page-morphology';
                break;
            case $qtype == "essay":
                $model = new Essay();
                $viewName = 'panels.user.test-page-essay';
                break;
            case $qtype == "qa":
                $model = new QualityAssurance();
                $viewName = 'panels.user.test-page-quality-assurance';
                break;
            case $qtype == "trans":
                $model = new Transfusion();
                $viewName = 'panels.user.test-page-transfusion';
                break;
            case $qtype == "haemo":
                $model = new Haemothromb();
                $viewName = 'panels.user.test-page-haemothromb';
                break;
            default:
                \Log::info("redirect code here");
        }


        $question = $model::where('id', $qid)->first();
        $dt = date("U");
        self::saveUserTest($dt, Auth::user()->id, [$question->id], with($model)->getTable(), with($model)->getTable(), "");

        return view($viewName, [
            'result' => $question,
            'index' => 0,
            'dt' => $dt,
            'questype' => isset($question->type) ? $question->type : '',
            'noques' => 1,
            'ans_after' => '',
            'q_type' => ''
        ]);
    }

    /**
     * @param $dt
     * @param $user_id
     * @param $ids
     * @param $table
     * @param $quesType
     * @param $subject
     */
    public static function saveUserTest($dt, $user_id, $ids, $table, $quesType, $subject)
    {
        UserTest::where('user_id', $user_id)->delete();

        $userTest = new UserTest();
        $userTest->uid = $dt;
        $userTest->user_id = $user_id;
        $userTest->data = implode(',', $ids);
        $userTest->type = $table;
        $userTest->qtype = $quesType;
        $userTest->subject = $subject;
        $userTest->save();
    }


    /**
     * @param S3Client $s3
     * @return array
     */
    public static function getFileNames($bucketName)
    {

        $credentials = new Credentials('AKIAJYLYN444TSH6CM5A', '3R5pXpfXmN2aUqNiU4Ld9Xqjod1hBb+GKo/1EW6S');
        $s3 = new S3Client([
            'version' => 'latest',
            "region" => "eu-west-2",
            'credentials' => $credentials
        ]);


        $results = $s3->ListObjects(array( 'Bucket' => $bucketName, 'Delimiter' => '/'));

        $folders = array();
        if ($results->get('CommonPrefixes')) {
            foreach ($results->get('CommonPrefixes') as $key => $value) {
                $name = substr($value['Prefix'], 0, strlen($value['Prefix']) -1 );
                array_push($folders, $name);
            }
        }

        $files = array();
        if ($results->get('Contents')) {
            foreach ($results->get('Contents') as $key => $value) {
                $name = $value['Key'];
                array_push($files, $name);
            }
        }

        return array("folders" => $folders, "files" => $files);
    }

    public static function saveAnnotation($slideId, $annoText, $annoXCoord, $annoYCoord, $annoZoom, $userId, $overLayId)
    {
        $slide = Slide::find($slideId);
        $annotation = new Annotation();
        $annotation->text = $annoText;
        $annotation->x_coord = $annoXCoord;
        $annotation->y_coord = $annoYCoord;
        $annotation->zoom = $annoZoom;
        $annotation->user_id = $userId;
        $annotation->overlay_id = $overLayId;
        $annotation->slide()->associate($slide);
        $annotation->save();
        $slide->annotations()->save($annotation);

        return $annotation;

    }

    public static function importFeatures($filename)
    {
        Feature::truncate();
        Investigation::truncate();
        Conclusion::truncate();
        $handle = fopen($filename, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $lineArray = explode("|", $line);
                $featureDescription = trim($lineArray[0]);
                $investigation = trim($lineArray[1]);
                $conclusion = trim($lineArray[2]);

                $existingFeature = Feature::where('description', $featureDescription)->first();
                if (isset($featureDescription) && !empty($featureDescription) && !isset($existingFeature)) {
                    $newFeature = new Feature();
                    $newFeature->description = $featureDescription;
                    $newFeature->save();
                }else {
                    Log::info("feature " . $featureDescription . " was not inserted");
                }

                $existingInves = Investigation::where('description', $featureDescription)->first();
                if (isset($investigation) && !empty($investigation) && !isset($existingInves)) {
                    $newInv = new Investigation();
                    $newInv->description = $investigation;
                    $newInv->save();
                }else {
                    Log::info("investigation " . $investigation . " was not inserted");
                }

                $existingConc = Conclusion::where('description', $conclusion)->first();
                if (isset($conclusion) && !empty($conclusion) && !isset($existingConc)) {
                    $newConc = new Conclusion();
                    $newConc->description = $conclusion;
                    $newConc->save();
                } else {
                    Log::info("conclusion " . $conclusion . " was not inserted");
                }
            }
            fclose($handle);
        } else {
            Log::info("Oops something went wrong with case resets ");
        }
    }


    public static function createMailChimpCampaign($icase_id, $message, $template_id, $list_id)
    {
        Log::info("creating campaign for case id {$icase_id} message: {$message} template id: {$template_id}, listid: {$list_id}");
        //$compelteDate = $pdate .'T'.$phour.':'.$pminute.':00+00:00';
        try {
            $mc = new MailChimp(env('MAILCHIMP_APIKEY'));
            $result = $mc->post("campaigns", [
                'type' => "regular",
                'recipients' => [
                    "list_id" => $list_id
                ],
                'settings' => [
                    "subject_line" => "New interactive case is published",
                    "preview_text" => "New interactive case is published preview",
                    "title" =>  $message . ' ' . $icase_id,
                    "from_name" => "BloodAcademy",
                    "reply_to" => "admin@blood-academy.com",
                    "to_name" => "*|FNAME|*",
                    "template_id" => intval($template_id)
                ]
            ]);

            $campaignId = $result['id'];
//            $result = $mc->get("/campaigns/{$campaignId}/send-checklist");
//            $resul2 = $mc->get("/campaigns/{$campaignId}");
            return $campaignId;

        } catch (Exception $e) {
            Log::info("Failed to create mailchimp campaign->" . $e->getMessage());
            return null;
        }

    }

    public static function addSubscriberToMC($list_id, $email, $first_name, $last_name, $subscriptionType)
    {
        try {
            $mc = new MailChimp(env('MAILCHIMP_APIKEY'));
            Log::info("ADDING MEMBER");
            $result = $mc->post("lists/$list_id/members", [
                'email_address' => $email,
                'status' => "subscribed",
                'merge_fields' => ['FNAME'=> $first_name,
                                    'LNAME'=> $last_name,
                                    'STYPE' => $subscriptionType],
            ]);
            Log::info($result);
            return $result;

        } catch (Exception $e) {
            Log::info("Failed to create mailchimp campaign->" . $e->getMessage());
            return null;
        }
    }

    public static function updateSubscriberMC($list_id, $email, $expire_at, $subscriptionType)
    {
        try {
            Log::info("UPDATING MEMBER with " . $expire_at ." and " . $subscriptionType . " for " . $email);
            $mc = new MailChimp(env('MAILCHIMP_APIKEY'));
            $subscriber_hash = $mc->subscriberHash($email);
            $result = $mc->patch("lists/$list_id/members/$subscriber_hash", [
                'merge_fields' => ['EXPIREAT' => "".$expire_at ."",
                                    'STYPE' => $subscriptionType]
            ]);

            Log::info($result);
            return $result;

        } catch (Exception $e) {
            Log::info("Failed to create mailchimp campaign->" . $e->getMessage());
            return null;
        }
    }

//    public static function updateMailChimpTempateDescription($old_description, $new_description, $notification_template_id, $report_template_id)
//    {
//        $description_place_holder = '#casedescription#';
//        $publish_place_holer = '#icasepublishdate#';
//
//        try {
//            $mc = new MailChimp(env('MAILCHIMP_APIKEY'));
//            $result = $mc->get("/templates/{$notification_template_id}");
//
//            return $result;
//
//        } catch (Exception $e) {
//            Log::info("Failed to create mailchimp campaign->" . $e->getMessage());
//            return null;
//        }
//    }



}