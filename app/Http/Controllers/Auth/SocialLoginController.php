<?php

namespace App\Http\Controllers\Auth;

use App\Events\Frontend\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProvider;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo()
    {
        $redirectTo = request()->redirectTo;

        if ($redirectTo) {
            return $redirectTo;
        } else {
            return RouteServiceProvider::HOME;
        }
    }

    /**
     * Redirect the user to the Provider (Facebook, Google, GitHub...) authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        Log::info('This is an informational message with variable: ' . $provider);
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Provider (Facebook, Google, GitHub...).
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        Log::info('This is an redirect message with variable: ' . $provider);
        /*$user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);*/
        try {
            $user = Socialite::driver($provider)->user();

            $authUser = $this->findOrCreateUser($user, $provider);
            Log::info('This is an redirect message ' );
            Auth::login($authUser, true);            
            return redirect()->route('backend.dashboard');
        } catch (Exception $e) {
            Log::info('This is an exception message ' . $e);
            return redirect('/');
        }

        //return redirect()->intended(RouteServiceProvider::HOME);
        return redirect()->route('backend.dashboard');
    }

    /**
     * Finds or creates a user based on the given social user and provider.
     *
     * @param  mixed  $socialUser  The social user object.
     * @param  string  $provider  The provider name.
     * @return \App\Models\User The found or created user.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user is not found.
     */
    private function findOrCreateUser($socialUser, $provider)
    {
        if ($authUser = UserProvider::where('provider_id', $socialUser->getId())->first()) {
            Log::info('This is first if ');
            $authUser = User::findOrFail($authUser->user->id);
            Log::info('This is first if ');
            return $authUser;
        } elseif ($authUser = User::where('email', $socialUser->getEmail())->first()) {
            Log::info('This is second condition ');
            UserProvider::create([
                'user_id' => $authUser->id,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'provider' => $provider,
            ]);

            return $authUser;
        } else {
            Log::info('This is third condition ');
            $name = $socialUser->getName();

            $name_parts = $this->split_name($name);
            $first_name = $name_parts[0];
            $last_name = $name_parts[1];
            $email = $socialUser->getEmail();

            if ($email == '') {
                Log::error('Social Login does not have email!');

                flash('Email address is required!')->error()->important();

                return redirect()->intended(RouteServiceProvider::HOME);
            }
            
            $user = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'name' => $name,
                'email' => $email,                
            ]);
            
           // $media = $user->addMediaFromUrl($socialUser->getAvatar())->toMediaCollection('users');
           // $user->avatar = $media->getUrl();
            
            $user->save();            
            event(new UserRegistered($user));

            UserProvider::create([
                'user_id' => $user->id,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'provider' => $provider,
            ]);

            return $user;
        }
    }

    /**
     * Split Name into first name and last name.
     */
    public function split_name($name)
    {
        $name = trim($name);

        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#'.$last_name.'#', '', $name));

        return [$first_name, $last_name];
    }
}
