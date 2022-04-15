<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            dd($user);

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser){
                Auth::login($finduser);
                return redirect()->intended('dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function handleWordpressCallback()
    {
        try {
            $user = Socialite::driver('wordpress')->user();
            dd($user);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function handleMicrosoftCallback()
    {
        try {
            $user = Socialite::driver('microsoft')->user();
            dd($user);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}