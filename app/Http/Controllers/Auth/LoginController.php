<?php

namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
   
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Your account is currently inactive. Please contact the administrator.');
            }

            $roleId = $user->role_id;
            $isCompany = $user->isCompany();
            $hasCompanyRelation = $user->company()->exists();
            
            Log::info('User login details', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role_id' => $roleId,
                'isCompany method' => $isCompany,
                'has company relation' => $hasCompanyRelation
            ]);
            
            if ($user->isCompany() && !$hasCompanyRelation) {
                Log::error('Company user without company record', ['user_id' => $user->id]);
                return redirect()->route('company.complete-registration')
                    ->with('warning', 'Please complete your company profile to continue.');
            }
            
            if ($user->isCompany() && !$user->company->is_validated) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('info', 'Your company account is pending approval from administrators.');
            }

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->isCompany()) {
                return redirect()->intended(route('company.dashboard'));
            } else {
                return redirect()->intended(route('home'));
            }
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}