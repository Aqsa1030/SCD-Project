<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    
    public function index()
    {
        return view('contact');
    }

    
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            Log::info('Contact form submitted', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => substr($validated['message'], 0, 100) . '...',
                'timestamp' => now(),
            ]);


            return back()->with('success', 'Thank you for contacting us, ' . $validated['name'] . '! We will get back to you soon.');

        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'] ?? 'unknown',
            ]);

            return back()->with('error', 'Failed to send message. Please try again later.')
                ->withInput();
        }
    }
}