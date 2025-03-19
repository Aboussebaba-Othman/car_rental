<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear all cookies to help with OAuth state
        $response = redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
            
        // Store the Google OAuth prompt parameter in session
        $request->session()->put('google_prompt', 'select_account');

        return $response;
    }
}