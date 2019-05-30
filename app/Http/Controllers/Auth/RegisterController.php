<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Traits\ActivationTrait;
use App\Traits\CaptchaTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\UtilsService;
use App;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, ActivationTrait, CaptchaTrait;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/protected';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $data['captcha'] = $this->captchaCheck();

        $validator = Validator::make($data,
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'password'              => 'required|min:6|max:20',
                'password_confirmation' => 'required|same:password',
                'g-recaptcha-response'  => 'required',
                'captcha'               => 'required|min:1',
            ],
            [
                'first_name.required' => 'First Name is required',
                'last_name.required' => 'Last Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Email is invalid',
                'password.required'     => 'Password is required',
                'password.min'          => 'Password needs to have at least 6 characters',
                'password.max'          => 'Password maximum length is 20 characters',
                'g-recaptcha-response.required' => 'Captcha is required',
                'captcha.min'           => 'Wrong captcha, please try again.',
            ]
        );

        return $validator;

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['email'],
            'email' => $data['email'],
            'country_residence' => $data['country_residence'],
            'city' => $data['city'],
            'password' => bcrypt($data['password']),
            'token' => str_random(64),
            'activated' => !config('settings.activation')
        ]);

        $role = Role::whereName('user')->first();
        $user->assignRole($role);

        UtilsService::addSubscriberToMC(env('MAILCHIMP_LIST'), $user->email, $user->first_name, $user->last_name, 0);
        //$this->initiateEmailActivation($user);

        \Mail::send('emails.registration',

            array(
                'name' => $user->first_name,
                'username' => $user->username,
            ), function($message) use ($user)
            {
                $message->from('admin@blood-academy.com');
                $message->to($user->email, $user->first_name)->subject('Subscription');
            });

        // create the object of FB
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $user_data = [
            'id' => $user->id,
            'name' => $user->first_name . " " . $user->last_name,
            'email' => $user->email
        ];
        $fb->add_user_to_fb($firebase, $user->id, $user_data);
        return $user;
    }
}