<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forget password form.
     *
     * @return \Illuminate\View\View
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle a forgot password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgotPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
    ], [
        'email.exists' => 'No account found with this email address',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $token = Str::random(64);
    $email = $request->email;

    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $email],
        [
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]
    );
    
    // Send the actual email
    Mail::send('emails.password-reset', ['token' => $token, 'email' => $email], function($message) use($request) {
        $message->to($request->email);
        $message->subject('Reset Password Notification');
    });

    return redirect()->back()
        ->with('success', 'Password reset link has been sent to your email address.');
}
}