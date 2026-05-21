<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\EmailVerifiedByAdminMail;

class AdminController extends Controller
{
    
    public function dashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $totalUsers = User::where('role', 'user')->count();
        
        return view('admin.dashboard', compact('totalUsers'));
    }

    public function users()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $users = User::where('role', 'user')->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function activateUser($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        try {
            $user = User::findOrFail($id);
            $admin = Auth::user();

            if ($user->email_verified_at) {
                return back()->with('info', 'This user is already active.');
            }
            $user->email_verified_at = now();
            $user->email_verification_token = null;
            
            $user->verified_by_admin_at = null;
            $user->verified_by_admin_id = null;
            
            $user->save();

            Log::info('✅ User activated by admin', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'admin_id' => $admin->id,
                'admin_email' => $admin->email,
            ]);

            try {
                Mail::to($user->email)->send(new EmailVerifiedByAdminMail($user, $admin));
                
                Log::info('✅ Activation email sent', [
                    'to' => $user->email,
                    'user_name' => $user->name,
                ]);

                return back()->with('success', '✅ User "' . $user->name . '" activated successfully! Welcome email sent.');
                
            } catch (\Exception $mailError) {
                Log::error('❌ Email sending failed', [
                    'error' => $mailError->getMessage(),
                ]);

                return back()->with('warning', '⚠️ User activated but email failed.');
            }

        } catch (\Exception $e) {
            Log::error('❌ User activation failed', [
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', '❌ Failed: ' . $e->getMessage());
        }
    }

    
    public function deactivateUser($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        try {
            $user = User::findOrFail($id);
            
            $user->email_verified_at = null;
            $user->save();

            Log::info('User deactivated', ['user_id' => $user->id]);

            return back()->with('success', 'User deactivated successfully.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed: ' . $e->getMessage());
        }
    }
}