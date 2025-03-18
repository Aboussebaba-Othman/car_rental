<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AccountTypeController extends Controller
{
    /**
     * Show the account type selection page.
     *
     * @return \Illuminate\View\View
     */
    public function showTypeSelection()
    {
        // Verify that we have social data
        if (!Session::has('social_data')) {
            return redirect()->route('login');
        }
        
        return view('auth.account-type');
    }
    
    /**
     * Process the account type selection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processTypeSelection(Request $request)
    {
        $request->validate([
            'account_type' => 'required|in:user,company',
        ]);
        
        if (!Session::has('social_data')) {
            return redirect()->route('login');
        }
        
        $socialData = Session::get('social_data');
        $nameParts = explode(' ', $socialData['name']);
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? end($nameParts) : '';
        
        if ($request->account_type === 'user') {
            // Create regular user account
            $user = User::create([
                'role_id' => Role::USER,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $socialData['email'],
                'password' => bcrypt(Str::random(16)),
                'avatar' => $socialData['avatar'],
                'is_active' => true,
            ]);
            
            Auth::login($user);
            Session::forget('social_data');
            
            return redirect()->route('home');
        } else {
            // Create company user account
            $user = User::create([
                'role_id' => Role::COMPANY,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $socialData['email'],
                'password' => bcrypt(Str::random(16)),
                'avatar' => $socialData['avatar'],
                'is_active' => true,
            ]);
            
            Auth::login($user);
            Session::forget('social_data');
            
            return redirect()->route('company.complete-registration');
        }
    }
}