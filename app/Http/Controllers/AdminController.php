<?php

namespace App\Http\Controllers;

use App\Annotation;
use App\Campaign;
use App\Emq;
use App\Http\Services\GuidelineService;
use App\Http\Services\StatsService;
use App\Http\Services\UtilsService;
use App\Icase;
use App\Mcase;
use App\Mcq;
use App\McqEmq;
use App\Models\Role;
use App\Models\User;
use App\Morphology;
use App\Sample;
use App\Slide;
use App\TablesFigures;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {

    private $paginationSize;
    public function __construct() {
        $this->paginationSize = 1000;
    }

    public function getAllSlides(Request $request)
    {
        $allSlides = Slide::all();
        return response()->json($allSlides);
    }

    public function getAnnotations(Request $request)
    {
        $slideId = Route::input('slideId');
        Log::info("getting annotations");
        $slide = Slide::with('annotations')->where("id", $slideId)->get();
        return response()->json($slide);
    }

    public function disImages(Request $request)
    {
        $all = TablesFigures::where('catagory', '!=', null)->orWhere('catagory', '!=', '')->get();
        return response()->json($all);
    }

    public function disSlides(Request $request)
    {
        $slides = Slide::all();
        return response()->json($slides);
    }


    public function getHome()
    {
        return view('panels.admin.home');
    }

    public function getMembers($type)
    {
        $users = [];
        switch ($type) {
            case "all":
                $users = DB::table('users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->leftjoin('payment_details', 'payment_details.user_id', '=', 'users.id')
                    ->select('users.*', 'role_user.user_id', 'role_user.role_id', 'payment_details.data')
                    ->where('role_user.role_id', '=', 1)
                    ->orderBy("created_at", "DESC")
                    ->paginate($this->paginationSize);
                break;
            case "active":
                $users = DB::table('users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->leftjoin('payment_details', 'payment_details.user_id', '=', 'users.id')
                    ->select('users.*', 'role_user.user_id', 'role_user.role_id', 'payment_details.data')
                    ->where('role_user.role_id', '=', 1)
                    ->where('users.expire_at', '>=', new \Carbon\Carbon())
                    ->orderBy("created_at", "DESC")
                    ->paginate($this->paginationSize);
                break;
            case "inactive":
                $users = DB::table('users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->leftjoin('payment_details', 'payment_details.user_id', '=', 'users.id')
                    ->select('users.*', 'role_user.user_id', 'role_user.role_id', 'payment_details.data')
                    ->where('role_user.role_id', '=', 1)
                    ->where('users.expire_at', '<', new \Carbon\Carbon())
                    ->orderBy("created_at", "DESC")
                    ->paginate($this->paginationSize);
        }

        return view('panels.admin.members', ['users'=> $users, "type" => $type]);
    }

    public function getSlideHub()
    {
        return view('panels.admin.slidehub', [
            'slides' => Slide::where('mcase_id', 0)->where('name', '!=', "")->get(),
            'cases' => Mcase::all(),
            'samples' => Sample::all()]);
    }


    public function getFigureHub()
    {
        $tablesfigures = TablesFigures::where('catagory', null)->get();
        $stored = TablesFigures::where('catagory', '!=', '')->get();

        return view('panels.admin.hub', ['tablesfigures' => $tablesfigures, 'storedFigures' => $stored]);
    }

    public function addFigure(Request $request)
    {
        $figureId = $request->get('figureid');
        $title = $request->get('figuretitle');
        $catagory = $request->get('catagory');
        $source = $request->get('source');
        $type = $request->get('type');
        $tableFigure = TablesFigures::where('figureid', $figureId)->first();
        $tableFigure->catagory = $catagory;
        $tableFigure->title = $title;
        $tableFigure->source = $source;
        $tableFigure->type = $type;
        $tableFigure->save();

        return redirect()->route('admin.figurehub');
    }

    public function resetFigure(Request $request)
    {
        $figureId = $request->get('figureId');
        $tableFigure = TablesFigures::where('id', $figureId)->first();
        $tableFigure->catagory = null;
        $tableFigure->save();
        return redirect()->route('admin.figurehub');
    }

    public function resetCase(Request $request)
    {
        $caseId = $request->get('caseId');
        $case = Mcase::find($caseId);
        foreach ($case->slides as $slide) {
            $slide->mcase()->dissociate();
            $slide->save();
        }
        return redirect()->route('admin.slidehub');
    }

    public function addSlide(Request $request)
    {
        $caseid = $request->get('caseid');
        $slideName = $request->get('slideid');
        $sampleType = $request->get('catagory');

        $myCase = Mcase::find($caseid);
        $mySample = Sample::where('name', $sampleType)->first();

        $mySlide = Slide::where('name', $slideName)->first();
        $mySlide->mcase()->associate($myCase);
        $mySlide->sample()->associate($mySample);
        $mySlide->save();
        return redirect()->route('admin.slidehub');
    }


    public function editMember()
    {

    	$user_id = Route::input('user_id');
    	$user = User::find($user_id);
        return view('panels.admin.edit-member', ['user'=> $user]);
    }

    public function updateMember(Request $request)
    {
        $subscription = 0;
        if ($request->get('subscription') == 'on') {
            $subscription = 1;
        }
    	$user = User::find(Input::get('user_id'));
        $user->first_name = Input::get('name');
    	$user->last_name = Input::get('lname');
        $user->password = bcrypt(Input::get('password'));
    	$user->current_hospital = Input::get('current_hospital');
    	$user->haematology = Input::get('haematology');
        $user->country_residence = Input::get('country_residence');
        $user->phone = Input::get('phone');
        $user->gender = Input::get('gender');
        $user->subscription = $subscription;
        if (empty($user->expire_at)) {
            $user->expire_at = date('Y-m-d', strtotime('+4 months'));
        }

        $user->save();

        $mailchimpExpiry = date('m/d/Y', strtotime($user->expire_at));
        UtilsService::updateSubscriberMC(env('MAILCHIMP_LIST'), $user->email, $mailchimpExpiry, $subscription);

        $request->session()->flash('alert-success', 'User updated successfully!');
		return redirect()->route('admin.members', ["type" =>"all"]);
    }

    public function addMember()
    {
        return view('panels.admin.add-member');
    }

    public function saveMember(Request $request)
    {
    	$requestData = $request->all();

        $subscribed = 1;
        if ($requestData['subtype'] == 'four') {
            $in_date = date('Y-m-d', strtotime('+4 months'));
        }
        if ($requestData['subtype'] == 'two') {
            $in_date = date('Y-m-d', strtotime('+2 months'));
        }

        if ($requestData['subtype'] == 'none') {
            $subscribed = 0;
            $in_date = "";
        }

    	$rules = array(
            'name'             => 'required|string',
            'email'            => 'required|email|unique:users',
        );
        $data = array(
            'name' => $requestData['name'],
            'email' => $requestData['email']
        );

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
           return redirect('admin/add-user')
                        ->withErrors($validator);
        } else {

	    	$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            //$password =  substr(str_shuffle(str_repeat($str, 5)), 0, 10);
    		$password = $requestData['password'];
            $unstr =  substr(str_shuffle(str_repeat($str, 5)), 0, 5);

            $first_email = explode("@", $requestData['email']);
            $un_email = $first_email[0]."_".$unstr;

			$user =  User::create([
                'first_name' => $requestData['name'],
			    'last_name' => $requestData['lname'],
			    'current_hospital' => $requestData['current_hospital'],
                'country_residence' => $requestData['country_residence'],
                'phone' => $requestData['phone'],
			    'gender' => $requestData['gender'],
			    'haematology' => $requestData['haematology'],
			    'expire_at' => $in_date,
			    'subscription' => $subscribed,
			    'email' => $requestData['email'],
			    'password' => bcrypt($password),
                'username'=> $requestData['email'],
			    'token' => str_random(64),
			    'activated' => !config('settings.activation')
			]);


            \Mail::send('emails.newuser',
                array(
                    'name' => $user->first_name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'password' => $password,
                ), function($message) use ($user)
                {
                    $message->from('admin@blood-academy.com');
                    $message->to($user->email, $user->first_name)->subject('New Register');
                });

			$role = Role::whereName('user')->first();
			$user->assignRole($role);
			$request->session()->flash('alert-success', 'User added successfully!');
			return redirect()->route('admin.members', ["type" => "all"]);

        }

    }

    public function deleteMember(Request $request)
    {
        $user_id = Route::input('user_id');
        $user = User::find($user_id);
        $user->delete();
        DB::table('role_user')->where('user_id', '=', $user_id)->delete();
        $request->session()->flash('alert-success', 'User deleted successfully!');
        return redirect()->route('admin.members', ["type" => "all"]);
    }

    public function deleteUpdates(Request $request)
    {
    	$rid = Route::input('rid');
		DB::table('recent_updates')->where('id', '=', $rid)->delete();
		$request->session()->flash('alert-success', 'Update deleted successfully!');
		return redirect()->route('admin.add-test');
    }

    public function cancelSubscription(Request $request)
    {
        $user_id = Route::input('id');
        $user = User::find($user_id);
        $user->expire_at = '';
        $user->subscription = 0;
        $user->save();
        $request->session()->flash('alert-success', 'Cancel membership successfully!');
        return redirect()->route('admin.members', ["type" => "all"]);
    }

    public function updateSubscription(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['user_id']);
        $user->expire_at = $data['date'];
        $user->subscription = 1;
        $user->save();
        $request->session()->flash('alert-success', 'Subscription updated successfully!');
        return redirect()->route('admin.members', ["type" => "all"]);
    }

    public function addTest()
    {
        $results = DB::table('recent_updates')
            ->select('recent_updates.*')
            ->paginate(15);

        return view('panels.admin.tests', [
                'results' => $results
            ]);
    }

    public function viewMcqEmq()
    {
        $results = DB::table('mcq_emq')->paginate($this->paginationSize);
        return view('panels.admin.mcq-emq', [
            'results' => $results
            ]);
    }

    public function addMcqEmq(Request $request)
    {
        $data = $request->all();

        if ($request->get('ans_type') == 'single') {
            $data['multiple_opts'] = UtilsService::formatNewEmqToOldEmq($data['choice'], $data['stem'], $data['selectedchoice2']);
        }

        $files = $request->file('file');
        $file_names = array();
        if($files && count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/mcq';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }

        $mcqEmq = new McqEmq();
        $mcqEmq->question = base64_encode($data['question']);
        $mcqEmq->subject = $data['subject'];
        $mcqEmq->type = $data['ans_type'];
        $mcqEmq->data = base64_encode(serialize($data['multiple_opts']));
        $mcqEmq->images = implode(',', $file_names);
        $mcqEmq->discussion = base64_encode($data['discussion']);
        $mcqEmq->reference = base64_encode($data['reference']);
        $mcqEmq->selimages = $data['simgs'];
        $mcqEmq->save();

        if ($request->get('ans_type') == 'single') {
            // single means EMQ dont ask why
            Emq::createEMQAndStemsIfNoneExist($mcqEmq->id, $data['multiple_opts']);
        } else {
            Mcq::createQuestionAndAnswersIfNoneExist($mcqEmq->id, $data['multiple_opts']);
        }

        $request->session()->flash('alert-success', 'Question added successfully!');
        return redirect()->route('admin.mcq-emq');
    }


    public function deleteQuestionmcq(Request $request)
    {
        $this->deleteQuestionAndStats(Route::input('r_id'));
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.mcq-emq');
    }

    public function editQuestionMcq()
    {
        $r_id = Route::input('r_id');
        $mcq = DB::table('mcq_emq')->where('id',  $r_id)->first();
        return view('panels.admin.edit-mcq-emq', [
            'mcq' => $mcq
        ]);
    }


    public function updateMcqEmq(Request $request)
    {

        $data = $request->all();

        if ($request->get('ans_type') == 'single') {
            $data['multiple_opts'] = $data['multiple_opts2'];
        }

        $files = $request->file('file');
        $file_names = array();
        if(isset($files) && count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/mcq';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }

        $affected = DB::table('mcq_emq')
            ->where('id', $data['id'])
            ->update(['question' => base64_encode($data['question']), 'selimages'=> $data['subject'], 'subject'=> $data['subject'], 'type'=> $data['ans_type'], 'selimages'=> $data['simgs'] ,'data'=> base64_encode(serialize($data['multiple_opts'])), 'images'=>implode(',', $file_names), 'discussion'=> base64_encode($data['discussion']), 'reference' => base64_encode($data['reference']) ]);

        // TODO update the question in the stats table
        $request->session()->flash('alert-success', 'Question updated successfully!');
        return redirect()->route('admin.mcq-emq');


    }

    public function viewEssayQuestions() {

        $results = DB::table('essay')->paginate($this->paginationSize);
        return view('panels.admin.essay-questions', [
            'results' => $results
            ]);
    }

    public function addEssayques(Request $request)
    {
        $data = $request->all();

        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/essay';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        // base64_decode(data)
        DB::insert('insert into essay (question, answer, images, discussion, subject, topic, reference, selimages) values (?, ?, ?, ?, ?, ?, ?, ?)', [ base64_encode($data['question']), base64_encode($data['answer']), implode(',', $file_names), base64_encode($data['discussion']), $data['subject'], base64_encode($data['topic']), base64_encode($data['reference']), $data['simgs']]);
        $request->session()->flash('alert-success', 'Question added successfully!');
        return redirect()->route('admin.essay-questions');
    }

    public function deleteQuestionEssay(Request $request)
    {
        $r_id = Route::input('r_id');
        DB::table('essay')->where('id', '=', $r_id)->delete();
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.essay-questions');
    }

    public function editQuestionEssay(Request $request)
    {
        $r_id = Route::input('r_id');
        $essay = DB::table('essay')->where('id',  $r_id)->first();
        return view('panels.admin.essay-edit', [
            'essay' => $essay
            ]);
    }

    public function UpdateEssayques(Request $request)
    {
        $data = $request->all();
        $files = $request->file('file');

        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/essay';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }

        $affected = DB::table('essay')
            ->where('id', $data['id'])
            ->update(['question' => base64_encode($data['question']), 'answer'=> base64_encode($data['answer']), 'discussion'=>base64_encode($data['discussion']),'subject'=> $data['subject'], 'images'=>implode(',', $file_names), 'topic'=> base64_encode($data['topic']), 'reference'=> base64_encode($data['reference']), 'selimages'=> $data['simgs']]);

        $request->session()->flash('alert-success', 'Question Updated successfully!');
        return redirect()->route('admin.essay-questions');
    }

    public function viewMorphology(Request $request)
    {
        $results = DB::table('morphology')->paginate($this->paginationSize);
        return view('panels.admin.morphology', [
            'results' => $results
            ]);
    }

    public function addMorphology(Request $request)
    {
        $file = $request->file('slide');
        $data = $request->all();

        $file_name = "";
        if($file) {
            $file_name = $file->getClientOriginalName();
            $file_ext = $file->getClientOriginalExtension();
            $file_name = date("U").'.'.$file_ext;
            $destinationPath = 'uploads';
            $file->move($destinationPath, $file_name);
        }

        $files = $request->file('file');
        $file_names = array();
        if(isset($files) && count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/morphology';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }

        $newMorphogy = new Morphology();
        $newMorphogy->short_longcase = base64_encode($data['short_longcase']);
        $newMorphogy->information = base64_encode($data['information']);
        $newMorphogy->data = base64_encode(serialize($data['question']));
        $newMorphogy->slide = $file_name;
        $newMorphogy->images = implode(',', $file_names);
        $newMorphogy->discussion = base64_encode($data['discussion']);
        $newMorphogy->type = $data['subject'];
        $newMorphogy->pdf = $data['pdf'];
        $newMorphogy->reference = base64_encode($data['reference']);
        $newMorphogy->slidename = base64_encode($data['slidename']);
        $newMorphogy->selimages = $data['simgs'];
        $newMorphogy->selslides = $data['sslides'];
        $newMorphogy->save();

        foreach (explode('|', $data['sslides']) as $slide) {
            $existingSlide = Slide::where('name', $slide)->first();
            $existingSlide->morphology()->associate($newMorphogy);
            $existingSlide->save();
        }


        $request->session()->flash('alert-success', 'Question added successfully!');
        return redirect()->route('admin.morphology');
    }

    public function deleteQuestionMorphology(Request $request)
    {
        $r_id = Route::input('r_id');
        DB::table('morphology')->where('id', '=', $r_id)->delete();
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.morphology');
    }

    public function editQuestionMorphology(Request $request)
    {
        $r_id = Route::input('r_id');
        $morphology = DB::table('morphology')->where('id',  $r_id)->first();

        return view('panels.admin.morphology-edit', [
            'morphology' => $morphology
            ]);
    }


    public function updateMorphology(Request $request)
    {
        $file = $request->file('slide');
        $data = $request->all();
        $file_name = "";
        if($file) {
            $file_name = $file->getClientOriginalName();
            $file_ext = $file->getClientOriginalExtension();
            $file_name = date("U").'.'.$file_ext;
            $destinationPath = 'uploads/morphology';
            $file->move($destinationPath, $file_name);
        }

        $files = $request->file('file');
        $file_names = array();
        if(isset($files) && count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/morphology';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }

        $morpholgy = Morphology::find($data['id']);
        $morpholgy->short_longcase = base64_encode($data['short_longcase']);
        $morpholgy->information = base64_encode($data['information']);
        $morpholgy->data = base64_encode(serialize($data['question']));
        $morpholgy->slide = $file_name;
        $morpholgy->images = implode(',', $file_names);
        $morpholgy->discussion = base64_encode($data['discussion']);
        $morpholgy->type = $data['subject'];
        $morpholgy->selimages = $data['simgs'];
        $morpholgy->selslides = $data['sslides'];
        $morpholgy->pdf = $data['pdf'];
        $morpholgy->reference = base64_encode($data['reference']);
        $morpholgy->save();

        //remove existing associations
        foreach ($morpholgy->slides as $slide) {
            $slide->morphology()->dissociate();
            $slide->save();
        }
        //add new associations
        foreach (explode('|', $data['sslides']) as $slide) {
            $existingSlide = Slide::where('name', $slide)->first();
            $existingSlide->morphology()->associate($morpholgy);
            $existingSlide->save();
        }

        $request->session()->flash('alert-success', 'Question updated successfully!');
        return redirect()->route('admin.morphology');
    }


    public function viewQualityAssurance(Request $request)
    {
        $results = DB::table('quality_assurance')->paginate($this->paginationSize);
        return view('panels.admin.quality-assurance', [
                'results' => $results
            ]);
    }

    public function addQualityAssurance(Request $request)
    {
        $data = $request->all();

        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/quality-assurance';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }

        $qdata = base64_encode(serialize($data['question']));

        DB::insert('insert into quality_assurance(topic, data, discussion, images, subject, reference, selimages) values(?, ?, ?, ?, ?, ?, ?)', [ base64_encode($data['topic']), $qdata, base64_encode($data['discussion']), implode(',', $file_names), $data['subject'], base64_encode($data['reference']), $data['simgs']]);
        $request->session()->flash('alert-success', 'Question added successfully!');
        return redirect()->route('admin.quality-assurance');
    }

    public function deleteQuestionQualityAssurance(Request $request)
    {
        $r_id = Route::input('r_id');
        DB::table('quality_assurance')->where('id', '=', $r_id)->delete();
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.quality-assurance');
    }

    public function editQualityAssurance(Request $request)
    {
        $r_id = Route::input('r_id');
        $qualityassurance = DB::table('quality_assurance')->where('id',  $r_id)->first();
        return view('panels.admin.edit-quality-assurance', [
            'qualityassurance' => $qualityassurance
            ]);
    }

    public function updateQualityAssurance(Request $request)
    {
        $data = $request->all();
        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/quality-assurance';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }

        $affected = DB::table('quality_assurance')
            ->where('id', $data['id'])
            ->update(['topic'=> base64_encode($data['topic']), 'selimages'=> $data['simgs'] ,'data'=> base64_encode(serialize($data['question'])), 'discussion' => base64_encode($data['discussion']), 'images'=>implode(',', $file_names), 'subject' => $data['subject'], 'reference' => base64_encode($data['reference']) ]);

        $request->session()->flash('alert-success', 'Question Updated successfully!');
        return redirect()->route('admin.quality-assurance');
    }

    public function viewTransfusion(Request $request)
    {
        $results = DB::table('transfusion')->paginate($this->paginationSize);
        return view('panels.admin.transfusion', [
                'results' => $results
            ]);
    }

    public function viewHaemoThromb(Request $request)
    {
        $results = DB::table('haemothromb')->paginate($this->paginationSize);
        return view('panels.admin.haemothromb', [
            'results' => $results
        ]);
    }


    public function addTransfusion(Request $request)
    {
        $data = $request->all();
        $files = $request->file('file');
        $file_names = array();
        if(isset($files) && count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/transfusion';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }

        $qdata = base64_encode(serialize($data['question']));
        DB::insert('insert into transfusion (qcase, information, data, discussion,  images, reference, selimages) values (?, ?, ?, ?, ?, ?, ?)',
            [   base64_encode($data['qcase']),
                base64_encode($data['information']),
                $qdata,
                base64_encode($data['discussion']),
                implode(',', $file_names),
                base64_encode($data['reference']),
                $data['simgs']] );
            $request->session()->flash('alert-success', 'Question added successfully!');
            return redirect()->route('admin.transfusion');
    }

    public function addGuideline(Request $request)
    {

        $data = $request->all();
        $title = base64_encode($data['title']);
        $summary = base64_encode($data['summary']);
        $references = base64_encode($data['references']);
        $category = $data['category'];
        $draft = 0;
        if (isset($data['draft'])) {
            $draft = 1;
        }

        if (isset ($data['id'])) {
            $id = $data['id'];
            GuidelineService::updateGuideline($id, $title, $summary, $references, $category, $draft);
            return redirect()->route('admin.guidelines');
        }

        GuidelineService::insertGuideline($title, $summary, $references, $category, $draft);
        $request->session()->flash('alert-success', 'Question added successfully!');
        return redirect()->route('admin.guidelines');
    }


    public function addHaemoThromb(Request $request)
    {
        $data = $request->all();

        $files = $request->file('file');
        $file_names = array();
        if(isset($files) && count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/haemo';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }

        $qdata = base64_encode(serialize($data['question']));

        DB::insert('insert into haemothromb (qcase, information, data, discussion,  images, reference, selimages) values (?, ?, ?, ?, ?, ?, ?)', [ base64_encode($data['qcase']), base64_encode($data['information']), $qdata, base64_encode($data['discussion']), implode(',', $file_names), base64_encode($data['reference']), $data['simgs']] );
        $request->session()->flash('alert-success', 'Question added successfully!');
        return redirect()->route('admin.haemothromb');

    }

    public function deleteQuestionTransfusion(Request $request)
    {
        $r_id = Route::input('r_id');
        DB::table('transfusion')->where('id', '=', $r_id)->delete();
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.transfusion');
    }

    public function deleteQuestionHaemothromb(Request $request)
    {
        $r_id = Route::input('r_id');
        DB::table('haemothromb')->where('id', '=', $r_id)->delete();
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.haemothromb');
    }

    public function deleteGuideline(Request $request)
    {
        $r_id = Route::input('r_id');
        GuidelineService::deleteGuideline($r_id);
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.guidelines');
    }

    public function editTransfusion(Request $request)
    {
        $r_id = Route::input('r_id');
        $transfusion = DB::table('transfusion')->where('id',  $r_id)->first();
        return view('panels.admin.edit-transfusion', [
            'transfusion' => $transfusion
            ]);
    }

    public function editGuideline(Request $request)
    {
        $r_id = Route::input('r_id');
        $transfusion = DB::table('guidelines')->where('id',  $r_id)->first();
        return view('panels.admin.edit-guideline', [
            'transfusion' => $transfusion
        ]);
    }

    public function editHaemoThromb(Request $request)
    {
        $r_id = Route::input('r_id');
        $transfusion = DB::table('haemothromb')->where('id',  $r_id)->first();
        return view('panels.admin.edit-haemothromb', [
            'transfusion' => $transfusion
        ]);
    }

    public function updateTransfusion(Request $request)
    {
        $data = $request->all();

        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/transfusion';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }


        $affected = DB::table('transfusion')
            ->where('id', $data['id'])
            ->update(['qcase'=> base64_encode($data['qcase']), 'selimages'=> $data['simgs'], 'information'=> base64_encode($data['information']), 'data'=> base64_encode(serialize($data['question'])), 'discussion' => base64_encode($data['discussion']), 'images'=>implode(',', $file_names),'reference'=> base64_encode($data['reference']) ]);

        $request->session()->flash('alert-success', 'Question Updated successfully!');
        return redirect()->route('admin.transfusion');
    }


    public function updateHaemoThromb(Request $request)
    {
        $data = $request->all();

        $files = $request->file('file');
        $file_names = array();
        if(isset($files) && count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/haemo';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }


        $affected = DB::table('haemothromb')
            ->where('id', $data['id'])
            ->update(['qcase'=> base64_encode($data['qcase']), 'selimages'=> $data['simgs'], 'information'=> base64_encode($data['information']), 'data'=> base64_encode(serialize($data['question'])), 'discussion' => base64_encode($data['discussion']), 'images'=>implode(',', $file_names),'reference'=> base64_encode($data['reference']) ]);

        $request->session()->flash('alert-success', 'Question Updated successfully!');
        return redirect()->route('admin.haemothromb');
    }

    public function previewQuestionMcq()
    {
        $r_id = Route::input('r_id');
        $mcq = DB::table('mcq_emq')->where('id',  $r_id)->first();
        return view('panels.admin.preview-mcq', [
                    'result' => $mcq
                ]);
    }

    public function previewQuestionEssay()
    {
        $r_id = Route::input('r_id');
        $essay = DB::table('essay')->where('id',  $r_id)->first();
        return view('panels.admin.preview-essay', [
                    'result' => $essay
                ]);
    }

    public function previewQuestionMorphology()
    {
        $r_id = Route::input('r_id');
        $morphology = DB::table('morphology')->where('id',  $r_id)->first();

        return view('panels.admin.preview-morphology', [
                    'result' => $morphology
                ]);
    }

    public function previewQuestionQuality()
    {
        $r_id = Route::input('r_id');
        $quality = DB::table('quality_assurance')->where('id',  $r_id)->first();

        return view('panels.admin.preview-quality', [
                    'result' => $quality
                ]);
    }

    public function previewQuestionTransfusion()
    {
        $r_id = Route::input('r_id');
        $transfusion = DB::table('transfusion')->where('id',  $r_id)->first();

        return view('panels.admin.preview-transfusion', [
                    'result' => $transfusion
                ]);
    }

    public function previewGuidleline()
    {
        $r_id = Route::input('r_id');
        $transfusion = DB::table('guidelines')->where('id',  $r_id)->first();

        return view('panels.admin.preview-guideline', [
            'result' => $transfusion
        ]);
    }

    public function previewQuestionHaemothromb()
    {
        $r_id = Route::input('r_id');
        $transfusion = DB::table('haemothromb')->where('id',  $r_id)->first();

        return view('panels.admin.preview-haemothromb', [
            'result' => $transfusion
        ]);
    }

    public function mcqPreview(Request $request)
    {

        $index = ( Route::input('index') ) ? Route::input('index') : 0;

        $results = DB::select('SELECT * FROM mcq_emq');

        if(isset($results[$index])) {
            return view('panels.admin.preview-mcq', [
                    'result' => $results[$index],
                    'index'=> $index
                ]);
        }else{
            $request->session()->flash('alert-success', 'No question found!');
            return redirect()->route('admin.mcq-emq');
        }
    }

    public function recentUpdates(Request $request)
    {
        $data = $request->all();
        DB::insert('insert into recent_updates (updates) values (?)', [ base64_encode($data['update']) ] );
        $request->session()->flash('alert-success', 'Updates added successfully!');
        return redirect()->route('admin.add-test');

    }

    public function pages()
    {
        $results = DB::select('SELECT * FROM pages');
        return view('panels.admin.pages', [
                'results' => $results
            ]);
    }

    public function updatePages(Request $request)
    {
        $data = $request->all();

        $results = DB::select('SELECT * FROM pages');
        if (count($results)) {
            $affected = DB::table('pages')
                ->where('id', 1)
                ->update([ 'about_us'=> base64_encode($data['about-us']), 'terms_use'=> base64_encode($data['terms-use']), 'home_page'=> base64_encode($data['home1']), 'home_page_about'=> base64_encode($data['home2']) ]);

        }else{
            DB::insert('insert into pages (about_us, terms_use, home_page, home_page_about) values (?,?,?,?)', [ base64_encode($data['about-us']), base64_encode($data['terms-use']), base64_encode($data['home1']), base64_encode($data['home2']) ] );
        }

        $request->session()->flash('alert-success', 'Pages content updated successfully!');
        return redirect()->route('admin.pages');
    }

    public function addInfo(Request $request)
    {
        $results = DB::select('SELECT * FROM information');
        return view('panels.admin.info', [
                'results' => $results
            ]);
    }

    public function guidelines()
    {
        $results = GuidelineService::getPublished();
        $drafts = GuidelineService::getDrafts();
        return view('panels.admin.guidelines', [
            'results' => $results,
            'drafts' => $drafts
        ]);
    }

    public function updateInfo(Request $request)
    {
        $data = $request->all();

        $results = DB::select('SELECT * FROM information');
        if (count($results)) {
            $affected = DB::table('information')
                ->where('id', 1)
                ->update([
                    'mcq_emq'=> base64_encode($data['mcq_emq']),
                    'essay'=> base64_encode($data['essay']),
                    'morphology'=> base64_encode($data['morphology']),
                    'quality_assurance'=> base64_encode($data['quality_assurance']),
                    'transfusion'=> base64_encode($data['transfusion']),
                    'haemo' => base64_encode($data['transfusion'])]);

        }else{
            DB::insert('insert into information (mcq_emq, essay, morphology, quality_assurance, transfusion, haemo) values (?,?,?,?,?,?)',
                [   base64_encode($data['mcq_emq']),
                    base64_encode($data['essay']),
                    base64_encode($data['morphology']),
                    base64_encode($data['quality_assurance']),
                    base64_encode($data['transfusion']),
                    base64_encode($data['haemo'])] );
        }

        $request->session()->flash('alert-success', 'Information updated successfully!');
        return redirect()->route('admin.info');

    }

    public function getTests(Request $request)
    {
        $user_id = Route::input('uid');
        $results = DB::table('user_tests')
            ->select('user_tests.*')
            ->where('user_id', '=', $user_id)
            ->paginate($this->paginationSize);

        return view('panels.admin.user-tests', [
                'results' => $results
            ]);
    }

    public function payHistory()
    {

        $results = DB::table('users')
            ->select('users.id','users.first_name','users.last_name','users.email','payment_details.user_id','payment_details.data','payment_details.created_at')
            ->join('payment_details','payment_details.user_id','=','users.id')
            ->paginate(15);

        return view('panels.admin.pay-history', [
                'results' => $results
            ]);
    }

    public function filterPayment(Request $request)
    {

        $dt_from = date('Y-m-d', strtotime($request->get('dt-from')));
        $dt_to = date('Y-m-d', strtotime($request->get('dt-to')));

        $results = DB::table('users')
            ->select('users.id','users.first_name','users.last_name','users.email','payment_details.user_id','payment_details.data','payment_details.created_at')
            ->join('payment_details','payment_details.user_id','=','users.id')
            ->whereBetween('payment_details.created_at', [ $dt_from, $dt_to])
            ->paginate(15);

        return view('panels.admin.pay-history', [
                'results' => $results
            ]);
    }

    public function migrateMorphology(Request $request)
    {
        foreach (Morphology::all() as $morpholgy) {
            foreach (explode('|', $morpholgy->selslides) as $slide) {
                $existingSlide = Slide::where('name', $slide)->first();
                $existingSlide->morphology()->associate($morpholgy);
                $existingSlide->save();
            }

        }
        response()->json("created relations");
    }
    public function fixDb(Request $request) {
        return view('panels.admin.fix-db');
    }

    public function viewComments(Request $request)
    {
        return view('panels.admin.view-comments');
    }

    public function getComments(Request $request)
    {
        $comments = UtilsService::getComments();
        return response()->json($comments);
    }

    public function manageCases(Request $request)
    {
        return view('panels.admin.manage-cases');
    }

    public function manageSampleType(Request $request)
    {
        return view('panels.admin.manage-sample-types');
    }


    public function fixSlideExtensions()
    {
        $allMorphology = Morphology::all();
        foreach ($allMorphology as $morpholgy) {
            $slidesNames = explode('|', $morpholgy->selslides);
            $newslidenames = [];
            foreach ($slidesNames as $slideName) {
                $slideArray = explode('.',$slideName);
                $basename = $slideArray[0];
                $extension = end($slideArray);
                if ($extension == 'jpg') {
                    array_push($newslidenames, $basename . '.dzi');
                }
            }
            $morpholgy->selslides = implode('|', $newslidenames);
            $morpholgy->save();
        }

        return response()->json("OK");
    }
    public function getAllSamples()
    {
        return response()->json(Sample::all());
    }

    public function addSample(Request $request)
    {
        $sampleName = $request->get('samplename');
        $sample = new Sample();
        $sample->name = $sampleName;
        $sample->save();
        return response()->json($sample);
    }

    public function addICase(Request $request)
    {
        $caseId = $request->get('caseId');
        $submittedBy = $request->get('submittedBy');
        $publishdate = $request->get('publishdate');
        $closedate = $request->get('closedate');
        $casedescription = $request->get('casedescription');
        $caseexplanation = $request->get('caseexplanation');
        $haemo = $request->get('haemo');
        $whitecell= $request->get('whitecell');
        $platelet= $request->get('platelet');
        $selectedSlides = $request->get('selectedSlides');
        $isdisplayed = $request->get('isdisplayed');
        $ispublic = $request->get('ispublic');

        $activeList= $request->get('activeList');
        $nonActiveList = $request->get('nonActiveList');
        $allMemebersList = $request->get('allMemebersList');

        $activeListTemplateId= $request->get('activeTemplateId');
        $nonActiveListTemplateId = $request->get('nonActiveTemplateId');
        $reportingTemplateId = $request->get('reportingTemplateId');

        Log::info("recieving activeList {$activeList}, nonactiveList {$nonActiveList}, allmemberesList {$allMemebersList}, activeTemplate {$activeListTemplateId}, nonactiveTemplate {$nonActiveListTemplateId}, reportingTemplate {$reportingTemplateId}");

        //only one public case is allowed.
        $publicases = Icase::where('ispublic', true)->get();
        foreach ($publicases as $case) {
            $case->ispublic = false;
            $case->save();
        }

        if (isset($caseId) && !empty($caseId)) {
            $icase = Icase::find($caseId);
            foreach ($icase->slides as $slide) {
                $slide->icase()->dissociate();
                $slide->save();
            }
            $icase = Icase::find($caseId);
            //$this->updateMailChimp($icase);
        }else {
            $icase = new Icase();
            $icase->save();
            $this->createMailChimp( $icase, $activeList, $nonActiveList, $allMemebersList,
                                    $activeListTemplateId, $nonActiveListTemplateId, $reportingTemplateId);
        }
        $icase->publish_date  = Carbon::createFromFormat('Y-m-d', $publishdate);
        $icase->closing_date = Carbon::createFromFormat('Y-m-d', $closedate);
        $icase->description = $casedescription;
        $icase->explanation = $caseexplanation;
        $icase->haemoglobin = $haemo;
        $icase->whitecell = $whitecell;
        $icase->platelet = $platelet;
        $icase->isdisplayed = $isdisplayed;
        $icase->ispublic = $ispublic;
        $icase->user()->associate(Auth::user());
        $icase->save();

        $slidesToSave = [];
        foreach ($selectedSlides as $slide) {
            $savedSlide = Slide::find($slide['id']);
            array_push($slidesToSave, $savedSlide);
        }

        $icase->slides()->saveMany($slidesToSave);



        return response()->json($icase);
    }

    public function getallicases()
    {
        return response()->json(Icase::with('slides')->orderBy('publish_date', "DESC")->get());
    }

    public function deleteIcase($icaseid)
    {
        Icase::destroy($icaseid);
        return redirect()->route('admin.icase');
    }


    public function importFigureFromBucket(Request $request)
    {
        $bucketName = $request->get('bucket_name');
        $alltablesfigures = [];
        $files = UtilsService::getFileNames($bucketName)['files'];
        foreach ($files as $file) {
            $existing = TablesFigures::where('figureid', $file)->first();
            if (!isset($existing)) {
                $tableFigure = new TablesFigures();
                $tableFigure->figureid = $file;
                $tableFigure->bucket_name = $bucketName;
                $tableFigure->save();
                array_push($alltablesfigures, $tableFigure);
            }
        }
        return response()->json($alltablesfigures);
    }

    public function importFeatures(Request $request)
    {
        $fileName = $request->get("file_name");
        UtilsService::importFeatures("./assets/images/" . $fileName);
        return response()->json("OK");
    }
    public function importFigure(Request $request)
    {
        $file_name = $request->get("file_name");
        $alltablesfigures = [];
        $handle = fopen("./assets/images/" . $file_name, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $lineArray      = explode("|", $line);
                $figureName     = trim($lineArray[0]);
                $figureTile     = trim($lineArray[1]);
                $figureCatagory = trim($lineArray[2]);
                $figureType     = trim($lineArray[3]);
                $bucket_name    = trim($lineArray[4]);
                $source         = trim($lineArray[5]);

                $tableFigure  = TablesFigures::where('figureid', $figureName)->first();

                if (!isset($tableFigure)) {
                    $tableFigure = new TablesFigures();
                    $tableFigure->figureid = $figureName;
                }
                $tableFigure->bucket_name = $bucket_name;
                $tableFigure->title = $figureTile;
                $tableFigure->catagory = $figureCatagory;
                $tableFigure->type = $figureType;
                $tableFigure->source = $source;
                $tableFigure->save();

                Log::info('saved : ' . json_encode($tableFigure));
                array_push($alltablesfigures, $tableFigure);

            }
            fclose($handle);
        } else {
            Log::info("Oops something went wrong with case resets ");
        }

        return response()->json($alltablesfigures);
    }

    public function removeSample(Request $request)
    {
        Sample::destroy($request->get("sample_id"));
        return response()->json("ok");
    }

    public function getAllCases()
    {
        return response()->json(Mcase::all());
    }

    public function removeWhiteSpaces()
    {
        $changed =  [];
        $cases = Mcase::all();
        foreach ($cases as $key => $case) {
            $oldDesc = $case->description;
            $newDesc = trim($oldDesc);
            if ($oldDesc != $newDesc) {
                Log::info('\''. $oldDesc . '\'' ." vs " . '\''. $newDesc . '\'');
                $case->description = $newDesc;
                $case->save();
                array_push($changed, $oldDesc);
            }
        }
        return response()->json($changed);
    }

    /**
     * @param Request $request
     * @param $file_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function importCases(Request $request, $file_name)
    {
        Mcase::truncate();
        Sample::truncate();
        //dissociate all slides
        foreach (Slide::all() as $slide) {
            Log::info("dissociating ". $slide->name);
            $slide->sample()->dissociate();
            $slide->mcase()->dissociate();
            $slide->save();
        }

        Log::info("processing file " . $file_name);
        $handle = fopen("./assets/images/" . $file_name, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $lineArray = explode("|", $line);
                $slideName = trim($lineArray[0]);
                $sampleType = trim($lineArray[3]);
                $caseDescription = trim($lineArray[4]);
                $caseCatagory = trim($lineArray[5]);

                $slide = Slide::where('name', $slideName . '.dzi')->first();
                if (isset($slide)) {

                    $case = Mcase::where('description', $caseDescription)->first();
                    if (!isset($case)) {
                        $case = new Mcase();
                        $case->catagory = $caseCatagory;
                        $case->description = $caseDescription;
                        $case->save();
                    }

                    $sample = Sample::where('name', $sampleType)->first();
                    if (!isset($sample)) {
                        $sample = new Sample();
                        $sample->name = $sampleType;
                        $sample->save();
                    }

                    Log::info("associating slide " . $slide->name . " with  case " . $case->description);
                    $slide->sample()->associate($sample);
                    $slide->mcase()->associate($case);
                    $slide->save();
                }
            }

            fclose($handle);
        } else {
            Log::info('error opening the file for importing cases filename :' . $file_name);
        }
        return response()->json("OK");
    }

    public function containSlide($slides, $slideName)
    {
        $slidesArray = explode('|', $slides);
        foreach ($slidesArray as $key => $value) {
            $existing = explode('//', $value)[0];
            if (explode('.', $existing)[0] == explode('.', $slideName)[0]) {
                return true;
            }
        }
        return false;
    }



    public function removeCase(Request $request)
    {
        $case_id = $request->get("case_id");
        Mcase::destroy($case_id);
        return response()->json("ok");
    }

    public function addCases(Request $request)
    {
        $caseDescription = $request->get("caseDescription");
        $mcase = new Mcase();
        $mcase->description = $caseDescription;
        $mcase->save();
        return response()->json($mcase);
    }

    public function manageSlides()
    {
        return view('panels.admin.manage-slides');
    }


    public function icase()
    {
        return view('panels.admin.icase');
    }

    public function getSlide(Request $request, $slide_id)
    {
        return view('panels.admin.slide', ["slide" => Slide::find($slide_id)]);
    }

    public function showSlideByName(Request $request, $slide_name)
    {
        $slide = Slide::where('name', $slide_name)->first();
        return view('panels.admin.slide', ["slide" => $slide]);
    }

    public function importSlides(Request $request, $bucket_name)
    {
        $filterByType = function ($n)
        {
            $extension = substr(strrchr($n,'.'),1);
            Log::info($n);
            if ($extension == 'dzi') {
                return $n;
            }
        };

        $filenames = UtilsService::getFileNames($bucket_name);
        $fliteredFileNames = array_filter($filenames['files'], $filterByType);
        foreach ($fliteredFileNames as $key => $filename) {
            Log::info("checking if slide name exist :::" . $filename);
            $slide = Slide::where('name', $filename)->first();
            if (!isset($slide)) {
                // check for reference in the old field 'slidename' but .jpg
                $plainName = basename($filename, '.dzi') . '.jpg';
                $slide = Slide::where('slidename', $plainName)->first();
                if (!isset($slide)) {
                    Log::info($filename . ' not found so saving a new one');
                    $slide = new Slide();
                }
                $slide->name = $filename;
            }
            $slide->slidename= $filename;
            $slide->bucket_name = $bucket_name;
            $slide->save();
        }
        return response()->json(Slide::all());
    }


    public function deleteAnnotation(Request $request)
    {
        Annotation::destroy($request->get("annotationId"));
        return response()->json("OK");
    }

    public function AddAnnotation(Request $request)
    {
        $slideId = $request->get("slideId");
        $xCoord = $request->get("xCoord");
        $yCoord = $request->get("yCoord");
        $message = $request->get("message");
        $viewportZoom = $request->get("zoom");
        $overLayId = $request->get("overlayId");

        $savedAnnotation = UtilsService::saveAnnotation($slideId, $message, $xCoord, $yCoord, $viewportZoom, Auth::user()->id, $overLayId);
        Log::info("Saved " . $savedAnnotation->id);
        return response()->json($savedAnnotation);
    }

    public function annotate(Request $request)
    {
        return view('panels.admin.view-new-slides');
    }

    public function fixchoiceIndecies(Request $request) {
        $questions = McqEmq::all();
        foreach ($questions as $key => $question) {
            $choices = unserialize(base64_decode($question->data));
            if ($question->type == 'multiple') {
                if (UtilsService::isCorrupt($choices)) {
                    $newChoices = UtilsService::indexFixer($choices);
                    $question->data = base64_encode(serialize($newChoices));
                    $question->save();
                    Log::info('fixed question id '. $question->id);
                }
            }
        }

        return view('panels.admin.fix-db');
    }

    /**
     * @param $r_id
     */
    public function deleteQuestionAndStats($r_id)
    {
        $mcqEmq = McqEmq::find($r_id);
        $type = $mcqEmq->type == "single" ? "emq" : "mcq";
        StatsService::deleteMcqEmqStats($type, $r_id);
        $mcqEmq->delete();
    }

    private function createMailChimp($icase, $active_list, $non_active_list, $allmembersList,
                                     $activeMembersTemplateId, $nonActiveMembersTemplateId, $report_template_id)
    {
        $activeNotificationCampaignTitle = "new_case_active";
        $nonActiveNotificationCampaignTitle = "new_case_non_active";
        $reportCampaignTitle = "report_case";

        $pActiveMembersCampaignId = UtilsService::createMailChimpCampaign($icase->id, $activeNotificationCampaignTitle, $activeMembersTemplateId, $active_list);
        $pNonActiveMembersCampaignId = UtilsService::createMailChimpCampaign($icase->id, $nonActiveNotificationCampaignTitle, $nonActiveMembersTemplateId, $non_active_list);
        $rCampaignId = UtilsService::createMailChimpCampaign($icase->id, $reportCampaignTitle, $report_template_id, $allmembersList);

        $pACampaign = new Campaign();
        $pACampaign->mc_campaign_id = $pActiveMembersCampaignId;

        $pNCampaign = new Campaign();
        $pNCampaign->mc_campaign_id = $pNonActiveMembersCampaignId;

        $rCampaign = new Campaign();
        $rCampaign->mc_campaign_id = $rCampaignId;

        $icase->campaigns()->saveMany([$pACampaign, $pNCampaign , $rCampaign]);

//        UtilsService::updateMailChimpTempateDescription($icase->description, $newDesription, $notification_template_id, $report_template_id);
    }
}
