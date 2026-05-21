<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerifyEmailMail;
use App\Mail\ResetPasswordMail;
use App\Mail\EmailVerifiedByAdminMail;
use App\Mail\NewUserRegistrationMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        try {
            $token = Str::random(64);

            $user = User::create([
                'name'                     => $request->name,
                'email'                    => $request->email,
                'password'                 => Hash::make($request->password),
                'email_verified_at'        => null, 
                'email_verification_token' => $token,
                'role'                     => 'user',
      
            ]);

            event(new Registered($user));

            $verificationLink = url('/verify-email/' . $token);

            try {
                Mail::to($user->email)->send(new VerifyEmailMail($verificationLink, $user));
                \Log::info('Verification email sent to: ' . $user->email);
            } catch (\Exception $mailError) {
                \Log::error('Mail sending failed: ' . $mailError->getMessage());
            }

            return redirect()->route('login')
                ->with('success', '✅ Registration successful! Please check your email for verification link.')
                ->with('verification_link', $verificationLink);
            
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            
            return back()
                ->withErrors(['email' => 'Registration failed. Error: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function verifyEmail($token)
    {
        \Log::info('Verification attempt with token: ' . $token);
        
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            \Log::error('Token not found: ' . $token);
            return redirect()->route('login')
                ->withErrors(['email' => 'Invalid or expired verification link.']);
        }

        if ($user->email_verified_at) {
            \Log::info('User already verified: ' . $user->email);
            return redirect()->route('login')
                ->with('info', '📧 Email already verified! You can now login.');
        }
        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        \Log::info('Email verified for user: ' . $user->email);

        return redirect()->route('login')
            ->with('success', '🎉 Email verified successfully! You can now login.');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (!Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => ['❌ Invalid email or password.'],
            ]);
        }

        $user = Auth::user();

        if (!$user->email_verified_at) {
            Auth::logout();
            
            throw ValidationException::withMessages([
                'email' => ['📧 Please verify your email before logging in. Check your inbox for verification link.'],
            ]);
        }

        $request->session()->regenerate();

        \Log::info('User logged in', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', '✅ Welcome back, Admin!');
        }

        return redirect()->intended(route('dashboard'))
            ->with('success', '✅ Welcome back, ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        $userName = Auth::user()->name ?? 'User';
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', '👋 Goodbye, ' . $userName . '! You have been logged out successfully.');
    }

    
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            $token = Str::random(64);
            
            $user->password_reset_token = $token;
            $user->password_reset_expires = now()->addHours(1);
            $user->save();

            $resetLink = url('/reset-password/' . $token);

            Mail::to($user->email)->send(new ResetPasswordMail($resetLink, $user));

            \Log::info('Password reset email sent to: ' . $user->email);
            \Log::info('Reset link: ' . $resetLink);

            return back()
                ->with('success', '✅ Password reset link has been sent to your email!')
                ->with('reset_link', $resetLink);
                
        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            
            return back()
                ->withErrors(['email' => 'Failed to send reset link. Please try again.']);
        }
    }

    
    public function showResetPassword($token)
    {
        $user = User::where('password_reset_token', $token)
            ->where('password_reset_expires', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Invalid or expired reset link. Please request a new one.']);
        }

        return view('auth.reset-password', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('password_reset_token', $request->token)
            ->where('password_reset_expires', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Invalid or expired reset link. Please request a new one.']);
        }

        $user->password = Hash::make($request->password);
        $user->password_reset_token = null;
        $user->password_reset_expires = null;
        $user->save();

        \Log::info('Password reset successful for: ' . $user->email);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', '✅ Password reset successfully! You are now logged in.');
    }

}