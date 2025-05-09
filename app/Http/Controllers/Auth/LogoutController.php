<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        $response = redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
            
        $request->session()->put('google_prompt', 'select_account');

        return $response;
    }
}