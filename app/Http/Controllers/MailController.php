<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Mail\MailModel;
use TransportException;
use Exception;
use App\Models\User;
use App\Models\Administrator;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MailController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendPasswordReset(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check for SMTP environment variables
        $missingVariables = [];
        $requiredEnvVariables = [
            'MAIL_MAILER',
            'MAIL_HOST',
            'MAIL_PORT',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'MAIL_ENCRYPTION',
            'MAIL_FROM_ADDRESS',
            'MAIL_FROM_NAME',
        ];

        foreach ($requiredEnvVariables as $envVar) {
            if (empty(env($envVar))) {
                $missingVariables[] = $envVar;
            }
        }

        if (!empty($missingVariables)) {
            return back()->withErrors(
                'Missing SMTP configuration: ' . implode(', ', $missingVariables),
            );
        }

        // Check if the user exists in the Users table
        $user = User::where('email', $request->email)->first();

        // If not found in Users table, check in the Administrator table
        if (!$user) {
            $user = Administrator::where('email', $request->email)->first();
        }

        if (!$user) {
            return back()->withErrors('No user found with this email address.');
        }

        // Check if the user has a Google ID
        if ($user instanceof User && $user->google_id) {
            return back()->withErrors('We cannot handle Google account passwords. Please use Google sign-in.');
        }

        // Generate a password reset token
        $token = Str::random(60);

        // Save the token to the database
        PasswordReset::updateOrCreate(
            ['email' => $user->email], // Match by email
            [
                'token' => Hash::make($token), // Save the hashed token
                'created_at' => Carbon::now(), // Set created_at timestamp
            ]
        );

        // Prepare email data
        $resetLink = url('/password/reset?token=' . $token . '&email=' . $user->email);
        $mailData = [
            'name' => $user->name,
            'email' => $user->email,
            'resetLink' => $resetLink,
        ];

        // Try sending the email
        try {
            Mail::to($user->email)->send(new MailModel($mailData));
            return redirect()->route('home')->withSuccess('We have sent a password reset link to ' . $user->email);
        } catch (TransportException $e) {
            return redirect()->back()->withErrors('SMTP connection error: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage());
        }

        return redirect()->route('home');
    }
}
