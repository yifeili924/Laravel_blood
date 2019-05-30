<?php

namespace App\Http\Middleware;

use App\Http\Services\UtilsService;
use App\Models\User;
use Closure;

class Subscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->subscription == 1 && !empty(auth()->user()->expire_at)) {
            // check if current date has surpassed the expiration date if so, set  subscription to 0
            $expiryDateString = auth()->user()->expire_at;
            $expiryDate = \Carbon\Carbon::createFromFormat("Y-m-d", $expiryDateString);
            $todayDate = new \Carbon\Carbon();

            if ($todayDate > $expiryDate) {
                $user = User::find(auth()->user()->id);
                $user->subscription = 0;
                $user->save();

                $newExp = \Carbon\Carbon::createFromFormat("d/m/Y", $expiryDateString);
                UtilsService::updateSubscriberMC(env('MAILCHIMP_LIST'), $user->email, $newExp, $user->subscription);
                return redirect()->route('public.payment');
            }
        }

        if ( (auth()->user()->subscription != 1) || auth()->user()->expire_at == "" ) {
            \Log::info('redirecting to payment page');
            return redirect()->route('public.payment');
        }

        return $next($request);
    }
}
