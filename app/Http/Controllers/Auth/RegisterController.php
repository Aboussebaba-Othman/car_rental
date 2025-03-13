<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Show the company registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showCompanyRegisterForm()
    {
        return view('auth.register-company');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'role_id' => Role::USER,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        auth()->login($user);

        return redirect()->route('home')->with('success', 'Account registered successfully!');
    }

    /**
     * Handle a company registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'legal_documents' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user account
        $user = User::create([
            'role_id' => Role::COMPANY,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        // Handle legal documents upload
        $legalDocumentsPath = null;
        if ($request->hasFile('legal_documents')) {
            $legalDocumentsPath = $request->file('legal_documents')->store('legal_documents', 'public');
        }

        // Create company profile
        Company::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'legal_documents' => $legalDocumentsPath,
            'is_validated' => false, // Requires admin validation
        ]);

        // Login the user
        auth()->login($user);

        return redirect()->route('company.dashboard')
            ->with('info', 'Your company account has been registered and is pending approval from our administrators.');
    }
}