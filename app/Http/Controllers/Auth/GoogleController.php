<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    
    public function redirectToGoogle(Request $request)
    {
        // Check if we need to prompt for account selection
        if ($request->session()->has('google_prompt')) {
            $request->session()->forget('google_prompt');
            return Socialite::driver('google')
                ->scopes(['openid', 'profile', 'email'])
                ->with(['prompt' => 'select_account'])
                ->redirect();
        }
        
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->email)->first();
            
            if ($user) {
                Auth::login($user);
                
                if ($user->isCompany()) {
                    return redirect()->route('company.dashboard');
                } else {
                    return redirect()->route('home');
                }
            }
            
            Session::put('social_data', [
                'provider' => 'google',
                'provider_id' => $googleUser->id,
                'email' => $googleUser->email,
                'name' => $googleUser->name,
                'avatar' => $googleUser->avatar,
            ]);
            
            return redirect()->route('auth.account.type');
            
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }
}