<?php

namespace App\Http\Controllers\Auth;

use App\Events\Frontend\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Modules\Captcha\Models\Captcha;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $captchaCount = Captcha::count();
        if($captchaCount!=0){
            $captcha = Captcha::first(); 
            $captchaStatus = $captcha->captcha_toggle;
        }
        else{
            $captchaStatus = "";
        }
        
        return view('auth.register')->with('captchaStatus',$captchaStatus);
    }

    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            //'password' => ['required', 'confirmed', 'min:10'],
           'password' => ['required', 'confirmed', Password::min(10)->mixedCase()->numbers()->symbols()->uncompromised()],
           'g-recaptcha-response' => 'required|captcha'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // username
        $username = config('app.initial_username') + $user->id;
        $user->username = $username;
        $user->save();

        event(new Registered($user));
        event(new UserRegistered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
