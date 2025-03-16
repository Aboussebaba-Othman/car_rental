<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user exists
            $user = User::where('email', $googleUser->email)->first();
            
            // If user doesn't exist, create a new one
            if (!$user) {
                $nameParts = explode(' ', $googleUser->name);
                $firstName = $nameParts[0];
                $lastName = count($nameParts) > 1 ? end($nameParts) : '';
                
                $user = User::create([
                    'role_id' => Role::USER, // Default role for Google signup
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $googleUser->email,
                    'password' => bcrypt(str::random(16)), // Random password
                    'avatar' => $googleUser->avatar,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
            }
            
            // Login the user
            Auth::login($user);
            
            // Redirect based on user role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isCompany()) {
                return redirect()->route('company.dashboard');
            } else {
                return redirect()->route('home');
            }
            
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }
}