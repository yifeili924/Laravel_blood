<?php

namespace App\Http\Controllers;

use App\Conclusion;
use App\Essay;
use App\Feature;
use App\Haemothromb;
use App\Http\Services\GuidelineService;
use App\Http\Services\ICasesService;
use App\Http\Services\StatsService;
use App\Http\Services\UtilsService;
use App\Icase;
use App\Investigation;
use App\Mcase;
use App\McqEmq;
use App\Models\User;
use App\Morphology;
use App\Payment;
use App\QualityAssurance;
use App\Slide;
use App\TablesFigures;
use App\Transfusion;
use App\UserQuestion;
use App\UserStat;
use App\UserTest;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Session;
use Stripe\Error\InvalidRequest;
use App\Models\Blog;
use App\Guideline;

use App;
class UserController extends Controller

{


    public function getHome()
    {
        $userStat = UserStat::findById(Auth::user()->id);
        $anStats = UserStat::getAnswerStats($userStat);
        $mcqCorrect = count($anStats['mcqCorrect']);
        $emqCorrect = count($anStats['emqCorrect']);
        $percentage = 0;
        $totalCorrect = $mcqCorrect + $emqCorrect;
        $totalIncorrect = count($anStats['mcqIncorrect']) + count($anStats['emqIncorrect']);
        $total = $anStats['total'];
        if ($total > 0 && $totalCorrect > 0) {
            $percentage = round($totalCorrect * 100 / $total);
        }

        $user = Auth::user();
        $payments = DB::table('payment_details')
            ->select('*')
            ->where('user_id', '=', $user->id)
            ->get();

        return view('panels.user.home', [
            'total' => $total,
            'correct' => $totalCorrect,
            'incorrect' => $totalIncorrect,
            'percentage' => $percentage,
            'payments' => $payments
        ]);

    }


    public function getPayments()

    {
        $user = Auth::user();

        $payments = DB::table('payment_details')
            ->select('*')
            ->where('user_id', '=', $user->id)
            ->get();

        return view('panels.user.payments', ['payments' => $payments]);
    }
    public function getBlogs()

    {
        $blogs = Blog::orderBy('id', 'desc')->get();
        return view('panels.user.blogs', ['blogs'=> $blogs]);


    }
    public function detailBlog($id)

    {

        $blogs = Blog::find($id);

        $user_id=Auth::user()->id;

        // update seen from "0" to "1"
        // create the object of FB
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $fb->update_seen($firebase, $user_id, $id, "blog");

        return view('panels.user.blog_detail', ['blogs'=> $blogs]);


    }


    public function getDashboard()
    {
        Log::info('dashboard ...');
        $results = DB::select('SELECT * FROM recent_updates');

        if (env('TRIAL_PERIOD') || auth()->user()->subscription != 1) {
            $limited = true;
        }

        if (auth()->user()->subscription == 1) {
            $limited = false;
        }

        return view('panels.user.dashboard', ['updates' => $results, 'limited' => $limited]);
    }


    public function verifyAccount()

    {
        return view('panels.user.verify');
    }


    public function getMcqEmqOpt()
    {
        $results = DB::select('SELECT * FROM information');
        $mcq_emq = (count($results)) ? $results[0]->mcq_emq : '';

        return view('panels.user.mcq-options', [
            'mcq_emq' => $mcq_emq
        ]);
    }


    public function getSubscribeForm()
    {
        return view('panels.user.subscription');
    }


    public function getPaymentPage()

    {
        return view('panels.user.subscription');
    }

    public function getCoupon(Request $request) {

        $coupon_id  = $request->get('coupon_id');
        $answer = 0;

        \Stripe\Stripe::setApiKey(env('STR_SEC'));
        // needs if coupon_id is not blank
        try {
            $coupon = \Stripe\Coupon::retrieve($coupon_id);
            $valid = true;
        } catch (InvalidRequest $e) {
            $valid = false;
        }

        if ($valid) {
            $answer = $coupon->percent_off;
        }

        echo $answer;
    }

    public function stripePayment(Request $request)
    {
        $subscriptionType = $request->get('subtype');
        if ($subscriptionType != 'four' && $subscriptionType != 'two' && $subscriptionType != 'three') {
            return redirect()->route('user.stripe-payment');
        }

        $subtype = 0;
        if ($subscriptionType == 'four') {
            $subtype = 1;
//            $amount = 8000;
            $in_date = date('Y-m-d', strtotime('+4 months'));
            $in_date_mailchimp = date('m/d/Y', strtotime('+4 months'));
        } else if ($subscriptionType == 'two') {
            $subtype = 1;
//            $amount = 6000;
            $in_date_mailchimp = date('m/d/Y', strtotime('+2 months'));
            $in_date = date('Y-m-d', strtotime('+2 months'));
        } else if ($subscriptionType == 'three'){
            $subtype = 2;
//            $amount = 5000;
            $in_date = date('Y-m-d', strtotime('+12 months'));
            $in_date_mailchimp = date('m/d/Y', strtotime('+12 months'));
        }

        $amount = $request->get('amount') * 100;

        \Stripe\Stripe::setApiKey(env('STR_SEC'));

        try {

            $charge = \Stripe\Charge::create(array(
                "amount" => $amount,
                "currency" => "GBP",
                "source" => $request->input('stripeToken'),
                "description" => "Test payment"
            ));

            $id = Auth::user()->id;
            $customer_array = $charge->__toArray(true);
            $user_payment = Payment::where('user_id', $id)->first();

            if (isset($user_payment)) {
                $user_payment->data = serialize($customer_array);
                $user_payment->save();
            } else {
                DB::insert('INSERT INTO payment_details (user_id, data) VALUES (?, ?)', [$id, serialize($customer_array)]);
            }

            $user = User::find($id);
            $user->expire_at = $in_date;
            $user->subscription = $subtype;
            $user->save();

            // update memeber at mailchimp here.
            UtilsService::updateSubscriberMC(env('MAILCHIMP_LIST'), $user->email, $in_date_mailchimp, $subtype);

            \Mail::send('emails.subscription',
                array(
                    'name' => $user->first_name,
                    'username' => $user->username,
                    'date' => $in_date,
                ), function ($message) use ($user) {
                    $message->from('admin@blood-academy.com');
                    $message->to($user->email, $user->first_name)->subject('Subscription');
                });


            $request->session()->flash('success-message', 'Payment done successfully!');

            return redirect()->route('user.home', ["payment" => "success"]);

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            $request->session()->flash('fail-message', 'Error! Please Try again.');
            return redirect()->back();
        }
    }

    public function getAnalytics() {
        $user = UserStat::findById(Auth::user()->id);
        $answerStats = UserStat::getAnswerStats($user);
        $totalCorrect = count($answerStats["mcqCorrect"]) + count($answerStats["emqCorrect"]);
        $total = $answerStats["total"];

        $percetage = 0;
        if ($total > 0) {
            $percetage = round($totalCorrect * 100 / $total);
        }


        $morphologyQuestions = $this->getAllQuesAndMarkSeen(new Morphology());
        $transQuestions = $this->getAllQuesAndMarkSeen(new Transfusion());
        $haemoQuestions = $this->getAllQuesAndMarkSeen(new Haemothromb());

        return view('panels.user.analytics', [
            'perc' => $percetage,
            'morphs' => $morphologyQuestions,
            'transfusions' => $transQuestions,
            'haemos' => $haemoQuestions
        ]);
    }


    public function getSampleMcqs()
    {
        return view('panels.user.sample-page-mcq');
    }

    public function getSampleMcqs2()
    {
        return view('panels.user.sample-page-mcq2');
    }

    public function getSampleMcqs3()
    {
        return view('panels.user.sample-page-mcq3');
    }

    public function getSampleTransfusion()
    {
        return view('panels.user.sample-page-transfusion');
    }

    public function getSampleMorphology()
    {
        return view('panels.user.sample-page-morphology');
    }

    public function reviewAll(Request $request)
    {
        return view('panels.user.viewallqs');
    }


    public function reviewSessionIncorrect(Request $request)
    {
        $userId = Auth::user()->id;

        $allSessionTests = Session::get('user.tests');
        $incorrectIds = [];
        foreach ($allSessionTests as $sessionTest) {
            if ($sessionTest['value'] == 'no' && !in_array($sessionTest['qid'], $incorrectIds)) {
                array_push($incorrectIds, $sessionTest['qid']);
            }
        }

        $table = 'mcq_emq';
        $dt = date("U");
        UtilsService::saveUserTest($dt, $userId, $incorrectIds, $table, $table, '');


        $question = McqEmq::where('id', $incorrectIds[0])->first();
        $request->session()->put('total_ques', count($incorrectIds));
        Session::forget('user.tests');
        return view('panels.user.test-page-mcq', [
            'result' => $question,
            'index' => 0,
            'dt' => $dt,
            'questype' => $table,
        ]);
    }
    public function reviewIncorrect(Request $request)
    {
        $userId = Auth::user()->id;
        $user = UserStat::findById($userId);
        $answers = UserStat::getAnswerStats($user);
        $mcqIncorrectAnswers = $answers['mcqIncorrect'];
        $emqIncorrectAnswers = $answers['emqIncorrect'];
        $allIncorrect = array_merge($mcqIncorrectAnswers, $emqIncorrectAnswers);

        $incorrectIds = [];
        foreach ($allIncorrect as $key => $value) {
            if (!in_array($value['question_id'], $incorrectIds)) {
                array_push($incorrectIds, $value['question_id']);
            }
        }

        $table = 'mcq_emq';
        $dt = date("U");
        UtilsService::saveUserTest($dt, $userId, $incorrectIds, $table, $table, '');


        if (count($incorrectIds) > 0) {
            $question = McqEmq::where('id', $incorrectIds[0])->first();
            $request->session()->put('total_ques', count($incorrectIds));

            return view('panels.user.test-page-mcq', [
                'result' => $question,
                'index' => 0,
                'dt' => $dt,
                'questype' => $table,
            ]);
        }

        $results = DB::select('SELECT * FROM recent_updates');
        return view('panels.user.dashboard', ['updates' => $results]);
    }

    public function getMcqQues(Request $request)
    {
        if (!$request->get('subject')) {
            $request->session()->flash('alert-success', 'Please select at least one subject');
            return redirect()->route('subscription.exam-mcq-emq-opt');
        }

        $sql = $this->createSql($request);

        $user_id = Auth::user()->id;
        $table = 'mcq_emq';

        $ids = $this->filterQuestionsIds($request->get('ques-seen'), $user_id, $sql, $table);

        if (!count($ids)) {
            $request->session()->flash('alert-success', 'No questions found for these options!');
            return redirect()->route('subscription.exam-mcq-emq-opt');
        }

        shuffle($ids);

        $que = $request->get('questions');
        if ($que != 'all') {
            if (count($ids) <= $que) {
                $que = count($ids);
            }
            $ids = array_slice($ids, 0, $que);
        }

        $quesType = $request->get('ques-type') ? $request->get('ques-type') : '';
        $subject = $request->get('subject') ? implode(',', $request->get('subject')) : '';

        $dt = date("U");
        UtilsService::saveUserTest($dt, $user_id, $ids, $table, $quesType, $subject);


        $request->session()->put('total_ques', count($ids));
        Session::forget('user.tests');

        $index = 0;

        $question = McqEmq::where('id', $ids[$index])->first();

        return view('panels.user.test-page-mcq', [
            'result' => $question,
            'index' => $index,
            'dt' => $dt,
            'questype' => $quesType,
        ]);
    }

    public function McqQuesPage(Request $request)
    {
        $uid = $request->get('dt');
        $index = $request->get('index');

        $tests = UserTest::where('uid', $uid)->first();

        $ids = explode(',', $tests->data);

        if ($request->get('previous')) {
            $index = $index - 1;
            $id = $ids[$index];
            $question = McqEmq::where('id', $id)->first();
            return view('panels.user.test-page-mcq', [
                                'result' => $question,
                                'index' => $index,
                                'dt' => $uid,
                                'questype' => $request->get('questype'),
                            ]);
        }

        $index = $index + 1;

        if(!isset($ids[$index])) {
            $test_result = Session::get('user.tests');
            $questions = McqEmq::find($ids);
            return view('panels.user.final-mcq', [
                'results' => $test_result,
                'tests' => $questions,
                'stats' => $this->getSessionStats()
            ]);
        }

        $id = $ids[$index];
        $question = McqEmq::where('id', $id)->first();

        return view('panels.user.test-page-mcq', [
                'result' => $question,
                'index' => $index,
                'dt' => $uid,
                'questype' => $request->get('questype'),
            ]);
    }

    private function getSeenQuestions(array $seenIds, array $ids)
    {
        $result = [];
        foreach ($ids as $key => $id) {
            if (in_array($id, $seenIds)) {
                array_push($result, $id);
            }
        }
        return $result;
    }

    private function getNewQuestions(array $seenIds, array $ids)
    {
        $questions = [];
        foreach ($ids as $key => $id) {
            if (!in_array($id, $seenIds)) {
                array_push($questions, $id);
            }
        }
        return $questions;
    }

    public function saveNote(Request $request)
    {
        $form_data = $request->all();

        $user_id = Auth::user()->id;

        $dt = date("U");

        $my_file =  $dt.'.txt';

        $handle = fopen('uploads/notes/'.$my_file, 'w') or die('Cannot open file:  '.$my_file);

        $data = $form_data['text'];

        fwrite($handle, $data);

        fclose($handle);


        $id = 0;
        if(!empty($form_data['text'])) {
            $id = DB::insert('INSERT INTO user_revision (user_id, uid, revision, qid) VALUES (?, ?, ?, ?)', [ $user_id, $dt, $form_data['text'], $form_data['qid'] ] );
            $id = DB::select('SELECT id FROM user_revision WHERE uid='.$dt);
            $id = (count($id)) ? $id[0]->id : 0;
        }
        $ky = '/uploads/notes/'.$my_file;
        return json_encode(array('key'=> $ky , 'id'=> $id ));

    }

    public function submitComment(Request $request)
    {
        $user = Auth::user();
        UtilsService::submitComment(
            $user->id,
            $user->details,
            $request->get('questionId'),
            $request->get('questionType'),
            $request->get('comment'),
            $request->get('cType'));

        return response()->json("OK");
    }

    public function getQuestion(Request $request, $qtype, $qid) {
        $request->session()->put('total_ques', 1);
        return UtilsService::getQuestionByTypeAndId($qtype, $qid);
    }


    public function getMorphology(Request $request) {
        $allQuestions = [];
        $morphologyQuestions = $this->getAllQuesAndMarkSeen(new Morphology());
        $mcqEmqQuestions = $this->getAllQuesAndMarkSeen(new McqEmq());
        $essaysQuestions = $this->getAllQuesAndMarkSeen(new Essay());
        $qaQuestions = $this->getAllQuesAndMarkSeen(new QualityAssurance());
        $transQuestions = $this->getAllQuesAndMarkSeen(new Transfusion());
        $haemoQuestions = $this->getAllQuesAndMarkSeen(new Haemothromb());
        $allQuestions['morphology'] = $morphologyQuestions;
        $allQuestions['mcqEmqs'] = $mcqEmqQuestions;
        $allQuestions['essays'] = $essaysQuestions;
        $allQuestions['qa'] = $qaQuestions;
        $allQuestions['trans'] = $transQuestions;
        $allQuestions['haemo'] = $haemoQuestions;
        return response()->json($allQuestions);
    }



    public function checkQuestion(Request $request)
    {
        $arr = $this->checkQue($request);
        $user_id = Auth::user()->id;


        if (count($arr)) {

            if($request->get('questype') == 'mcqs') {
                $arr2 = array();
                foreach ($arr as $key => $va) {
                    if ($va['key'] == $va['uans']) {
                        $right = ($va['value'] == 'yes') ? 'yes' : 'no';
                        array_push($arr2, array('key'=> $va['key'], 'value'=> $va['value'], 'qid' => $va['qid']));
                    }
                }

                $found = false;
                if (Session::has('user.tests')) {
                    $sessionTests = Session::get('user.tests');
                    foreach ($sessionTests as $test) {
                        foreach ($arr2 as $newTest) {
                            $testQid = $test['qid'];
                            $newTestQid = $newTest['qid'];
                            if ($testQid == $newTestQid) {
                                $found = true;
                            }
                        }
                    }
                }
                if (!$found) {
                    foreach ($arr2 as $mcq) {
                        Session::push('user.tests', $mcq);
                        Session::save();
                    }
                }
            } else {

                $found = false;
                if (Session::has('user.tests')) {
                    $sessionTests = Session::get('user.tests');
                    foreach ($sessionTests as $test) {
                        foreach ($arr as $newTest) {
                            $testQid = $test['qid'];
                            $newTestQid = $newTest['qid'];
                            if ($testQid == $newTestQid) {
                                $found = true;
                            }
                        }
                    }
                }
                if (!$found) {
                    foreach($arr as $emq) {
                        Session::push('user.tests', $emq);
                        Session::save();
                    }
                }
            }
        }

        $stats = $this->getSessionStats();


        $table = 'mcq_emq';
        $this->updateUserQuestions($user_id, $request->get('qid'), $table);

        return response()->json(["arr" => $arr, "stats" => $stats]);
    }



    public function checkQue($request)

    {
        $arr = array();
        $uid = $request->get('dt');

        $test = DB::table('user_tests')
            ->select('*')
            ->where('uid', '=', $uid)
            ->first();

        $ids = explode(',', $test->data);
        if (in_array($request->get('qid'), $ids)) {
            $que = McqEmq::where('id', $request->get('qid'))->first();
            $ques_ans = unserialize(base64_decode($que->data));
            $user_ans = $request->get('que_ans');
            $qId = $request->get('qid');

            if (count($user_ans)) {
                if($request->get('questype') == 'emqs') {
                    $stats = StatsService::manageEmqStats(Auth::user()->id, $qId, $ques_ans, $user_ans);
                    foreach ($stats["stems"] as $key => $stem) {
                        $right = $stem["isUserCorrect"] ? "yes" : "no";
                        array_push($arr, array(
                            'key'=> $stem["stemIndex"],
                            'value'=> $right,
                            'qid' => $qId,
                            'choiceStats' => $stem["statCorrect"]));
                    }

                } else {
                    $stats = StatsService::manageMcqStats(
                        Auth::user()->id,
                        $request->get('qid'),
                        $ques_ans,
                        $user_ans[0]);

                    $realIndex = -1;
                    foreach ($ques_ans as $key => $val) {
                        $realIndex++;
                        $right = (isset($ques_ans[$key][1])) ? 'yes' : 'no';
                        array_push($arr, array(
                            'key'=> $key,
                            'value'=> $right,
                            'uans'=> $user_ans[0],
                            'qid' => $request->get('qid'),
                            'choiceStats' => $stats['stats'][$key],
                            'total' => $stats['total']));
                    }
                }
            }
        }
        return $arr;
    }



    // Essay type ques

    public function getEssayOpt(Request $request)

    {

        $results = DB::select('SELECT * FROM information');

        $essay = (count($results)) ? $results[0]->essay : '';



        $general = DB::table('essay')

            ->select('*')

            ->where('subject', '=', 'general-haematology')

            ->get();

        $transfusion = DB::table('essay')

            ->select('*')

            ->where('subject', '=', 'transfusion')

            ->get();

        $haemato = DB::table('essay')

            ->select('*')

            ->where('subject', '=', 'haemato-oncology')

            ->get();

        $haemastasis = DB::table('essay')

            ->select('*')

            ->where('subject', '=', 'haemastasis-thrombosis')

            ->get();



        return view('panels.user.essay-options', [

                'general'     => $general,

                'transfusion' => $transfusion,

                'haemato'     => $haemato,

                'haemastasis' => $haemastasis,

                'essay' => $essay

            ]);

    }



    public function getEssayQues(Request $request)

    {
        $user_id = Auth::user()->id;
        $index = 0;
        $dt = date("U");
        $arr = array();

        if($request->get('general-haematology')){
            array_push($arr, $request->get('general-haematology'));
        }

        if($request->get('transfusion')){
            array_push($arr, $request->get('transfusion'));
        }

        if($request->get('haemato-oncology')){
            array_push($arr, $request->get('haemato-oncology'));
        }

        if($request->get('haemastasis-thrombosis')){
            array_push($arr, $request->get('haemastasis-thrombosis'));
        }

        $ids = Essay::find($arr)->pluck('id')->toArray();

        if(!count($ids)){
            $request->session()->flash('alert-success', 'No questions found for these options!');
            return redirect()->route('subscription.exam-essay-questions');
        }

        $type = 'essay';
        $keys = array_keys($request->all());
        $subject = (isset($keys[1])) ? $keys[1] : '';


        UtilsService::saveUserTest($dt, $user_id, $ids, $type , $type, $subject);

        $request->session()->put('total_ques', count($ids));

        Session::forget('user.tests');

        $essay = Essay::where('id', $ids[$index])->first();

        return view('panels.user.test-page-essay', [
                'result' => $essay,
                'index' => $index,
                'dt' => $dt
            ]);
    }



    public function EssayQuesPage(Request $request)

    {
        $uid = $request->get('dt');

        $tests = UserTest::where('uid', $uid)->first();

        $ids = explode(',', $tests->data);

        $question = Essay::where('id', $ids[0])->first();
        return view('panels.user.test-page-essay-ans', [
            'result' => $question,
            'answer' => $request->get('answer'),
            'index' => $request->get('index'),
            'dt' => $uid
        ]);
    }



    public function getMorphologyOpt()

    {
        $results = DB::select('SELECT * FROM information');
        $morphology = (count($results)) ? $results[0]->morphology : '';

        return view('panels.user.morphology-options', [
                'morphology' => $morphology
            ]);
    }



    public function getMorphologyQues(Request $request)
    {
        $user_id = Auth::user()->id;
        $sql = $this->getMorphologySql($request);
        $table = 'morphology';
        $ids = $this->filterQuestionsIds($request->get('q_seen'), $user_id, $sql, $table);

        if(!count($ids)){
            $request->session()->flash('alert-success', 'No questions found for these options!');
            return redirect()->route('subscription.exam-morphology');
        }

        //lets randomize
        shuffle($ids);

        $que = $request->get('no_ques');
        if($que != 'all') {
            if(count($ids) <= $que) {
                $que = count($ids);
            }
            $ids = array_slice($ids, 0, $que);
        }


        $dt = date("U");
        $quesType = $request->get('q_type') ? $request->get('q_type') : '';
        $subject = '';
        UtilsService::saveUserTest($dt, $user_id, $ids, $table, $quesType, $subject);

        $request->session()->put('total_ques', count($ids));
        Session::forget('user.tests');

        $index = 0;
        $question = Morphology::where('id', $ids[$index])->first();
        return view('panels.user.test-page-morphology', [
                'result' => $question,
                'index' => $index,
                'noques' => $que,
                'dt' => $dt,
                'ans_after' => $request->get('ans_after'),
                'q_type' => $request->get('q_type'),
            ]);
    }



    public function MorphologyQuesPage(Request $request)

    {
        $uid = $request->get('dt');
        $index = $request->get('index');
        $user_id = Auth::user()->id;

        $tests = UserTest::where('uid', $uid)->first();
        $ids = explode(',', $tests->data);
        if(!isset($ids[$index])) {
            $test_result = Session::get('user.tests');
            return view('panels.user.final-morphology', [
                'results' => $test_result
            ]);
        }

        $id = $ids[$index];

        if ($request->get('submit')) {
            $this->updateUserQuestions($user_id, $id, 'morphology');
        }

        if ( $request->get('skip') || $request->get('ans_after') == 'end' ) {
            $index = $index + 1;
            if(!isset($ids[$index])) {
                $test_result = Session::get('user.tests');
                return view('panels.user.final-morphology', [
                    'results' => $test_result
                ]);
            }

            $id = $ids[$index];
            $question = Morphology::find($id);
            return view('panels.user.test-page-morphology', [
                'result' => $question,
                'index' => $index,
                'dt' => $uid,
                'noques' =>  $request->get('noques'),
                'ans_after' => $request->get('ans_after'),
                'q_type' => $request->get('q_type'),
                'ans' => $request->get('ans'),
            ]);

        }

        if ( $request->get('previous')) {
            $index = $index - 1;
            $id = $ids[$index];
            $question = Morphology::find($id);
            return view('panels.user.test-page-morphology', [
                'result' => $question,
                'index' => $index,
                'dt' => $uid,
                'noques' =>  $request->get('noques'),
                'ans_after' => $request->get('ans_after'),
                'q_type' => $request->get('q_type'),
                'ans' => $request->get('ans'),
            ]);
        }

        $question = Morphology::find($id);
        return view('panels.user.test-page-morphology-ans', [
                'result' => $question,
                'index' => $index,
                'dt' => $uid,
                'noques' =>  $request->get('noques'),
                'ans_after' => $request->get('ans_after'),
                'q_type' => $request->get('q_type'),
                'ans' => $request->get('ans'),
            ]);
    }



    public function MorphologyQuesNextPage(Request $request)
    {
        $uid = $request->get('dt');
        $index = $request->get('index');

        $tests = UserTest::where('uid', $uid)->first();
        $ids = explode(',', $tests->data);

        if(!isset($ids[$index])) {
            $test_result = Session::get('user.tests');
            return view('panels.user.final-morphology', [
                'results' => $test_result
            ]);
        }

        $id = $ids[$index];
        $question = Morphology::find($id);

        return view('panels.user.test-page-morphology', [
                'result' => $question,
                'index' => $index,
                'dt' => $uid,
                'ans_after' => $request->get('ans_after'),
                'noques' => $request->get('noques'),
                'q_type' => $request->get('q_type')
            ]);
    }



    public function getQualityAssuranceOpt(Request $request)
    {

        $general = DB::table('quality_assurance')
            ->select('*')
            ->where('subject', '=', 'general-haematology')
            ->get();


        $transfusion = DB::table('quality_assurance')
            ->select('*')
            ->where('subject', '=', 'transfusion')
            ->get();


        $haemastasis = DB::table('quality_assurance')
            ->select('*')
            ->where('subject', '=', 'haemastasis-thrombosis')
            ->get();

        $results = DB::select('SELECT * FROM information');
        $quality_assurance = (count($results)) ? $results[0]->quality_assurance : '';

        return view('panels.user.quality-assurance-options', [
                'general'     => $general,
                'transfusion' => $transfusion,
                'haemastasis' => $haemastasis,
                'quality_assurance' => $quality_assurance
            ]);
    }





    public function getQualityAssuranceQues(Request $request)

    {
        $user_id = Auth::user()->id;
        $index = 0;
        $dt = date("U");

        $arr = array();

        if($request->get('general-haematology')){
            array_push($arr, $request->get('general-haematology'));
        }

        if($request->get('transfusion')){
            array_push($arr, $request->get('transfusion'));
        }

        if($request->get('haemastasis-thrombosis')){
            array_push($arr, $request->get('haemastasis-thrombosis'));
        }

        $strippedIds = QualityAssurance::find($arr)->pluck('id')->toArray();

        if(!count($strippedIds)){
            $request->session()->flash('alert-success', 'No questions found for these options!');
            return redirect()->route('subscription.exam-quality-assurance');
        }

        $type = 'quality_assurance';
        $keys = array_keys($request->all());
        $subject = (isset($keys[1])) ? $keys[1] : '';

        UtilsService::saveUserTest($dt, $user_id, $strippedIds, $type, $type, $subject);

        $request->session()->put('total_ques', count($strippedIds));
        Session::forget('user.tests');

        $question = QualityAssurance::find($strippedIds[$index]);
        return view('panels.user.test-page-quality-assurance', [
                'result' => $question,
                'index' => $index,
                'dt' => $dt
            ]);
    }



    public function QualityAssuranceQuesPage(Request $request)

    {
        $uid = $request->get('dt');
        $index = $request->get('index');

        $tests = UserTest::where('uid', $uid)->first();

        $ids = explode(',', $tests->data);

        $question = QualityAssurance::find($ids[$index]);

        return view('panels.user.test-page-quality-assurance-ans', [
                'result' => $question,
                'index' => $index,
                'dt' => $uid,
                'ans' => $request->get('ans'),
            ]);
    }


    public function getHaemothrombOpt(Request $request)
    {
        $results = DB::select('SELECT * FROM information');
        $haemo = (count($results)) ? $results[0]->haemo : '';
        return view('panels.user.haemothromb-options', [
            'haemoInfo' => $haemo
        ]);
    }

    public function showCase(Request $request, $case_id, $sample_type)
    {
        $otherSamples = [];
        $showSlide = null;
        $case = Mcase::find($case_id);
        foreach ($case->slides as $slide) {
            $slideName = $slide->name;
            $sampleType = $slide->sample->name;

            if ($sampleType == $sample_type) {
                \Log::info("Inside =  " . $sampleType . " searching for " . $slideName);
                $showSlide = $slide;
            } else {
                array_push($otherSamples, $sampleType);
            }
        }
        Log::info(json_encode($otherSamples));

        $user_id=Auth::user()->id;

        // update seen from "0" to "1"
        // create the object of FB
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $fb->update_seen($firebase, $user_id, $case_id, $sample_type);

        return view('panels.user.show-case', [
            'case' => $case,
            'slide' => $showSlide,
            "sampleType" => $sample_type,
            'otherSamples' => json_encode($otherSamples)]);
    }


    public function showSlide(Request $request, $slide_id)
    {
        $slide = Slide::find($slide_id);
        return view('panels.user.show-slide', ['slide' => $slide]);
    }

    public function submitIcase(Request $request)
    {
        $selInv = $request->get('investigations');
        $selConc = $request->get('concs');
        $selFeatureSet = $request->get('featureset');
        $icaseId = $request->get('caseId');
        $finalised = $request->get('finalised');

        $invs = [];
        foreach ($selInv as $inv) {
            array_push($invs, Investigation::find($inv['id']));
        }

        $concs = [];
        foreach ($selConc as $conc) {
            array_push($concs, Conclusion::find($conc['id']));
        }

        $featureSet = [];
        foreach ($selFeatureSet as $fs) {
            $slide = Slide::find($fs['slideId']);
            $features = [];
            foreach ($fs['features'] as $featureid) {
                array_push($features, Feature::find($featureid));
            }
            array_push($featureSet, ["slide" => $slide, "features" => $features]);
        }

        $submission = ICasesService::submitAnswers(User::find(Auth::user()->id), Icase::find($icaseId), $invs, $concs, $featureSet, $finalised);

        return response()->json($submission);
    }

    public function getIcaseUserAnswers($icaseId)
    {
        $submission = User::find(Auth::user()->id)->submissions()->where('icase_id', $icaseId)->first();

        if (isset($submission)) {
            $fs = [];
            foreach ($submission->featuresets as $featureset) {
                $slideId = $featureset->slide->id;
                $features = $featureset->features;
                array_push($fs, ["slideId" => $slideId, "features" => $features]);
            }
            return response()->json([
                "inv" => $submission->investigations,
                "concs" => $submission->conclusions,
                "fs" => $fs]);
        }else {
            return response()->json([
                "inv" => [],
                "concs" => [],
                "fs" => []]);
        }
    }
    public function getFeatures()
    {
        return response()->json(["feature" => Feature::all(),
                                 "inv" => Investigation::all(),
                                 "conc" => Conclusion::all()]);
    }

    public function getIcase($icaseid)
    {
        return response()->json(Icase::find($icaseid));
    }

    public function getIcasePage($icaseid)
    {
        $icase = Icase::find($icaseid);
        $today = Carbon::now();
        $closingDate = new Carbon($icase->closing_date);
        if ($closingDate->gte($today)) {
            return view('panels.user.icasehub', ["icase" => $icase]);
        } else {
            return view('panels.user.pasticasehub', ["icase" => $icase]);
        }
    }

    public function getIcasePagePublic()
    {
        $icase = Icase::where('ispublic', true)->first();
        return view('panels.user.publicicase', ["icase" => $icase]);
    }

    public function getIcaseReport($icaseid)
    {
        return response()->json(ICasesService::getReport($icaseid));
    }
    public function getIcases()
    {
        $icases = Icase::where('isdisplayed', true)->orderBy('publish_date', "DESC")->get();
        $currentCases = [];
        $pastcases = [];
        foreach ($icases as $icase) {
            $today = Carbon::now();
            $closingDate = new Carbon($icase->closing_date);
            if ($closingDate->gte($today)) {
                array_push($currentCases, $icase);
            } else {
                array_push($pastcases, $icase);
            }
        }
        return view('panels.user.icaseshub', ["currentcases" => $currentCases, "pastcases" => $pastcases]);
    }
    public function getHubSlides(Request $request)
    {
        $lymphoid = Mcase::where('catagory', 'LYMPHOID')->get();
        $myeloid = Mcase::where('catagory', 'MYELOID')->get();
        $redcell = Mcase::where('catagory', 'RED CELL')->get();
        $other = Mcase::where('catagory', 'Miscellaneous')->get();

        return view('panels.user.slideshub',
            [
                'lymphoids' => $lymphoid,
                'myeloids' => $myeloid,
                'redcells' => $redcell,
                'others' => $other]);
    }

    public function getHubFigures(Request $request)
    {
        //TablesFigures::where('catagory', "");
        $all = DB::table("tablesfigures")
            ->get()->toArray();

        $mals = array_filter($all, function($n){
            return ($n->catagory == 'haemato-oncology');
        });

        $thrombs = array_filter($all, function($n){
            return ($n->catagory == 'haemostasis');
        });

        $trans = array_filter($all, function($n){
            return ($n->catagory == 'transfusion');
        });

        $generals = array_filter($all, function($n){
            return $n->catagory == 'haemotology';
        });

        return view('panels.user.figureshub',
                ['mals' => $mals, 'thrombs' => $thrombs, 'trans' => $trans, 'generals' => $generals]);
    }

    public function getGuidlinesSummaries()
    {
        $all = GuidelineService::getPublished();

        $mals = array_filter($all, function($n){
            return ($n->category == 'haemato-oncology');
        });

        $thrombs = array_filter($all, function($n){
            return ($n->category == 'haemostasis');
        });

        $trans = array_filter($all, function($n){
            return ($n->category == 'transfusion');
        });

        $generals = array_filter($all, function($n){
            return $n->category == 'haemotology';
        });

        return view('panels.user.guidelinesummaries',
            ['mals' => $mals, 'thrombs' => $thrombs, 'trans' => $trans, 'generals' => $generals]);
    }


    public function getInteractiveModules()
    {
        return view('panels.user.interactive-modules');
    }


    public function getModule($modTitle, $modFolder, $moduleName)
    {

        return view('panels.user.displaymodule', ["mod_title"=> $modTitle, "mod_folder"=> $modFolder, "mod_name" => $moduleName]);
    }


    public function getTransfusionOpt(Request $request)
    {
        $results = DB::select('SELECT * FROM information');
        $transfusion = (count($results)) ? $results[0]->transfusion : '';
        return view('panels.user.transfusion-options', [
            'transfusion' => $transfusion
        ]);
    }


    public function TransfusionQuesPage(Request $request)
    {
        $id = Auth::user()->id;
        $tests = DB::select('SELECT * FROM `transfusion` ');

        if(!count($tests)){
            $request->session()->flash('alert-success', 'No questions found for these options!');
            return redirect()->route('subscription.exam-transfusion');
        }


        $user_id = Auth::user()->id;
        $table = 'transfusion';

        $ids = $this->filterQuestionsIds($request->get('q_seen'), $user_id, '', $table);
        shuffle($ids);

        $que = $request->get('questions');
        if ($que != 'all') {
            if(count($ids) <= $que) {
                $que = count($ids);
            }
            $ids = array_slice($ids, 0, $que);
        }

        if(!count($ids)){
            $request->session()->flash('alert-success', 'No questions found for these options!');
            return redirect()->route('subscription.exam-transfusion');
        }

        $dt = date("U");

        UtilsService::saveUserTest($dt, $user_id, $ids, $table, $table, '');
        $request->session()->put('total_ques', count($ids));
        Session::forget('user.tests');

        $index = 0;
        $question = Transfusion::find($ids[$index]);
        return view('panels.user.test-page-transfusion', [
                'result' => $question,
                'index' => $index,
                'noques' => $que,
                'dt' => $dt,
                'ans_after' => $request->get('ans_after')
            ]);
    }

    public function TransfusionQues(Request $request)
    {
        $uid = $request->get('dt');
        $index = $request->get('index');
        $user_id = Auth::user()->id;
        $tests = UserTest::where('uid', $uid)->first();

        $ids = explode(',',$tests->data);
        $id = $ids[$index];

        if ($request->get('submit')) {
            $this->updateUserQuestions($user_id, $id, "transfusion");
        }

        if ($request->get('skip') || $request->get('ans_after') == 'end' ) {
            $index = $index + 1;
            if(!isset($ids[$index])) {
                $test_result = Session::get('user.tests');
                return view('panels.user.final-transfusion', [
                    'results' => $test_result
                ]);
            }

            $question = Transfusion::find($ids[$index]);
            return view('panels.user.test-page-transfusion', [
                'result' => $question,
                'index' => $index,
                'noques' => $request->get('noques'),
                'dt' => $uid,
                'ans_after' => $request->get('ans_after'),
                'ans' => $request->get('ans'),
            ]);
        }

        if ($request->get('previous')) {
            $index = $index - 1;
            $question = Transfusion::find($ids[$index]);
            return view('panels.user.test-page-transfusion', [
                'result' => $question,
                'index' => $index,
                'noques' => $request->get('noques'),
                'dt' => $uid,
                'ans_after' => $request->get('ans_after'),
                'ans' => $request->get('ans'),
            ]);
        }
        $question = Transfusion::find($ids[$index]);
        return view('panels.user.test-page-transfusion-ans', [
            'result' => $question,
            'index' => $index,
            'dt' => $uid,
            'noques' => $request->get('noques'),
            'ans' => $request->get('ans'),
            'ans_after' => $request->get('ans_after'),
        ]);
    }

    public function TransfusionQuesNextPage(Request $request)

    {
        $uid = $request->get('dt');
        $index = $request->get('index');

        $tests = UserTest::where('uid', $uid)->first();

        $ids = explode(',', $tests->data);

        if(!isset($ids[$index])) {
            $test_result = Session::get('user.tests');
            return view('panels.user.final-transfusion', [
                'results' => $test_result
            ]);
        }

        $question = Transfusion::find($ids[$index]);

        return view('panels.user.test-page-transfusion', [
            'result' => $question,
            'index' => $index,
            'noques' => $request->get('noques'),
            'dt' => $uid,
            'ans_after' => $request->get('ans_after')
        ]);
    }

    public function HaemothrombQuesPage(Request $request)
    {
        $type = 'haemothromb';
        $ids = DB::select('SELECT id FROM `haemothromb` ');

        if(!count($ids)){
            $request->session()->flash('alert-success', 'No questions found for these options!');
            return redirect()->route('subscription.exam-haemothromb');
        }

        $user_id = Auth::user()->id;

        $ids = $this->filterQuestionsIds($request->get('q_seen'), $user_id, '', $type);

        shuffle($ids);

        $que = $request->get('questions');
        if ($que != 'all') {
            if(count($ids) <= $que) {
                $que = count($ids);
            }
            $ids = array_slice($ids, 0, $que);
        }

        if(!count($ids)){
            $request->session()->flash('alert-success', 'No questions found for these options!');
            return redirect()->route('subscription.exam-haemothromb');
        }

        $dt = date("U");

        UtilsService::saveUserTest($dt, $user_id, $ids, $type, $type, '');
        $request->session()->put('total_ques', count($ids));
        Session::forget('user.tests');

        $index = 0;
        $question = Haemothromb::find($ids[$index]);
        return view('panels.user.test-page-haemothromb', [
            'result' => $question,
            'index' => $index,
            'noques' => $que,
            'dt' => $dt,
            'ans_after' => $request->get('ans_after')
        ]);
    }


    public function HaemothrombQues(Request $request)
    {
        $uid = $request->get('dt');
        $index = $request->get('index');
        $user_id = Auth::user()->id;
        $tests = UserTest::where('uid', $uid)->first();
        $type = 'haemothromb';

        $ids = explode(',', $tests->data);

        if ($request->get('submit')) {
            //$this->insertUpdateUserQuestions($ids, $index, $user_id, $type);
            $this->updateUserQuestions($user_id, $ids[$index], $type);

            $question = Haemothromb::find($ids[$index]);
            return view('panels.user.test-page-haemothromb-ans', [
                'result' => $question,
                'index' => $index,
                'dt' => $uid,
                'noques' => $request->get('noques'),
                'ans' => $request->get('ans'),
                'ans_after' => $request->get('ans_after'),
            ]);
        }


        if ($request->get('skip') || $request->get('sub')) {
            $index = $index + 1;
            if(!isset($ids[$index])) {
                $test_result = Session::get('user.tests');
                return view('panels.user.final-haemostasis', [
                    'results' => $test_result
                ]);
            }
        } else if ($request->get('previous')) {
            $index = $index - 1;
        }

        $question = Haemothromb::find($ids[$index]);
        return view('panels.user.test-page-haemothromb', [
            'result' => $question,
            'index' => $index,
            'noques' => $request->get('noques'),
            'dt' => $uid,
            'ans_after' => $request->get('ans_after'),
            'ans' => $request->get('ans'),
        ]);
    }

    public function editProfilePage() {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        return view('panels.user.edit-profile', ['user'=> $user]);
    }



    public function updateUser(Request $request)
    {
        $requestData = $request->all();
        if($requestData['email']) {

            $rules = array(

                'email'            => 'required|email|unique:users',

            );

            $data = array(

                'email' => $requestData['email']

            );

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {

                return redirect('user/edit-profile')

                        ->withErrors($validator);

            } else {

                $user_id = Auth::user()->id;

                $user = User::find($user_id);

                $user->email = $requestData['email'];

                $user->username = $requestData['email'];

                $user->save();

                $request->session()->flash('alert-success', 'User updated successfully!');

                return redirect()->route('user.edit-profile');



            }

        }

    }



    public function updateUserPass(Request $request)

    {



        $requestData = $request->all();

        $rules = array(

            'password'              => 'required|min:6|max:20',

            'password_confirmation' => 'required|same:password',

        );

        $data = array(

            'password' => $requestData['password'],

            'password_confirmation' => $requestData['password_confirmation']

        );

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {

            return redirect('user/edit-profile')

                        ->withErrors($validator);

        }else{

            $user_id = Auth::user()->id;

            $user = User::find($user_id);

            $user->password = bcrypt($requestData['password']);

            $user->save();

            $request->session()->flash('alert-success', 'User updated successfully!');

            return redirect()->route('user.edit-profile');

        }
    }


    public function figurePage($fid)
    {
        $figure = TablesFigures::where('figureid', $fid)->first();
        if (!isset($figure->bucket_name) || empty($figure->bucket_name)) {
            $figure->bucket_name = "tablesfigures";
        }

        $user_id=Auth::user()->id;

        // update seen from "0" to "1"
        // create the object of FB
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $fb->update_seen($firebase, $user_id, $fid, "figure");

        return view("panels.user.figurepage", ["figure" => $figure]);
    }

    public function guidlinePage($fid)
    {
        $guidline = Guideline::find($fid);

        $user_id=Auth::user()->id;

        // update seen from "0" to "1"
        // create the object of FB
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $fb->update_seen($firebase, $user_id, $fid, "guidline");

        return view("panels.user.guidelinepage", ["figure" => $guidline]);
    }


    public function slidePage($sname, $stype, $cid)
    {
        $cases = DB::table("cases")->select("*")
            ->where("id", "=", $cid)->get();
        $case = $cases[0];
        return view("panels.user.slidepage", ["case" => $case, "sname" => $sname, "stype" => $stype]);
    }

    public function getAnnotations($slide_id)
    {
        $slide = Slide::with('annotations')->where("id", $slide_id)->get();
        return response()->json($slide);
    }

    public function resetStats()
    {
        UserStat::resetStats(Auth::user()->id);
        return redirect('user/analytics');
    }


    public function invoicePage()
    {
        $id = Route::input('pid');
        $user = Auth::user();


        $payment = DB::table('payment_details')
            ->select('*')
            ->where('user_id', '=', $user->id)
            ->where('id', '=', $id)
            ->get();



        return view('panels.user.invoice', [

            'payment' => $payment,

            'user' => $user

        ]);

    }

    /**
     * @param Request $request
     * @return string
     */
    public function createSql(Request $request)
    {
        $sql = "";

        if (($request->get('ques-type') || $request->get('subject')) &&
            ($request->get('ques-type') != 'mcqs-emqs' || $request->get('subject'))) {
            $sql .= "WHERE";
        }

        if ($request->get('ques-type') != 'mcqs-emqs') {
            if ($request->get('ques-type')) {
                $type = ($request->get('ques-type') == 'mcqs') ? 'multiple' : 'single';
                $sql .= " `type`='" . $type . "' ";
            }

            if ($request->get('ques-type') && $request->get('subject')) {
                $sql .= "AND";
            }
        }

        if ($request->get('subject')) {
            $subjects = implode("','", $request->get('subject'));
            $sql .= " `subject` IN('" . $subjects . "') ";
        }
        return $sql;
    }

    /**
     * @param Request $request
     * @param $sql
     * @return array
     */
    public function getMorphologySql(Request $request)
    {
        $sql  = "";
        if ($request->get('q_type') == 'short-cases' || $request->get('q_type') == 'long-cases') {
            $type = $request->get('q_type');
            $sql .= " WHERE `type`='" . $type . "' ";
        }

        if ($request->get('q_type') == 'short-long') {
            $type = $request->get('q_type');
            $sql .= " WHERE `type` IN ('short-cases','long-cases','short-long') ";
        }
        return $sql;
    }

    /**
     * @param $quesSeen
     * @param $user_id
     * @param $sql
     * @param $table
     * @return array
     */
    public function filterQuestionsIds($quesSeen, $user_id, $sql, $table)
    {
        $user_questions = DB::table('user_questions')->where(['type' => $table, 'user_id' => $user_id])->first();
        $seenIds = [];
        if (isset($user_questions)) {
            $seenIds = explode(',', $user_questions->question_ids);
        }


        $ids = DB::select('SELECT id FROM ' . $table . ' ' . $sql);
        $ids = array_column($ids, 'id');
        if ($quesSeen == 'seen') {
            $ids = $this->getSeenQuestions($seenIds, $ids);
        }
        if ($quesSeen == 'not_seen') {
            $ids = $this->getNewQuestions($seenIds, $ids);
        }
        return $ids;
    }


    /**
     * @param $user_id
     * @param $id
     * @param $tableName
     */
    public function updateUserQuestions($user_id, $id, $tableName)
    {
        $user_questions = UserQuestion::where(
            ['user_id' => $user_id,
                'type' => $tableName])->first();

        if (isset($user_questions)) {
            $questionArray = explode(',', $user_questions->question_ids);
            if (!in_array($id, $questionArray)) {
                array_push($questionArray, $id);
            }
            $q = implode(",", $questionArray);
            $user_questions->question_ids = $q;
            $user_questions->save();
        } else {
            $userQuestion = new UserQuestion();
            $userQuestion->user_id = $user_id;
            $userQuestion->question_ids = $id;
            $userQuestion->type = $tableName;
            $userQuestion->save();
        }
    }

    /**
     * @param $model
     * @return array
     */
    public function getAllQuesAndMarkSeen($model)
    {
        $questions = [];
        $seenQuestions = [];
        $morphologyqs = $model::orderBy('id', 'asc')->pluck('id')->toArray();
        $userQuestions = UserQuestion::where(['user_id' => Auth::user()->id, 'type' => with($model)->getTable()])->first();
        if (isset($userQuestions)) {
            $seenQuestions = explode(",", $userQuestions->question_ids);
        }
        foreach ($morphologyqs as $key => $question) {
            $seen = false;
            if (in_array($question, $seenQuestions)) {
                $seen = true;
            }
            array_push($questions, ["id" => $question, "seen" => $seen]);
        }

        return $questions;
    }

    /**
     * @param $stats
     * @return mixed
     */
    public function getSessionStats()
    {
        $stats = null;
        if (Session::has('user.tests')) {
            $sessionAnswers = Session::get('user.tests');
            $stats['total'] = count($sessionAnswers);
            $stats['totalCorrect'] = 0;
            foreach ($sessionAnswers as $answer) {
                if ($answer['value'] == "yes") {
                    $stats['totalCorrect']++;
                }
            }
            $stats['totalInCorrect'] = $stats['total'] - $stats['totalCorrect'];
        }
        return $stats;
    }
}
