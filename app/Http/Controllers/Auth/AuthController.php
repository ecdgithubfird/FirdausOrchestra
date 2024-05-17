<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

class AuthController extends Controller
{
    public function redirectToAzure()
    {
        return Socialite::driver('azure')->redirect();
    }

    public function handleAzureCallback(Request $request)
    {
        $user = Socialite::driver('azure')->user();

        // Handle user authentication and redirection

        return redirect()->route('backend.dashboard');
    }
}