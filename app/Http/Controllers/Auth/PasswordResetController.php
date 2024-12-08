<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\Administrator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    // Show the password reset form
    public function showResetForm(Request $request)
    {
        // Get the token and email from the query string
        $token = $request->query('token');
        $email = $request->query('email');

        // Check if the token is valid
        $passwordReset = PasswordReset::where('email', $email)->first();

        if (!$passwordReset || !Hash::check($token, $passwordReset->token)) {
            return redirect()->route('password.request')->withErrors('Invalid token or email.');
        }

        // Check if the token has expired (15 minutes expiration)
        if (Carbon::parse($passwordReset->created_at)->addMinutes(15)->isPast()) {
            return redirect()->route('password.request')->withErrors('This password reset link has expired.');
        }

        // Token is valid, show the reset form
        return view('auth.password-reset', ['token' => $token, 'email' => $email]);
    }

    // Handle the password reset process
    public function resetPassword(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|max:25|confirmed',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the token and email from the request
        $token = $request->input('token');
        $email = $request->input('email');

        // Find the password reset record
        $passwordReset = PasswordReset::where('email', $email)->first();

        if (!$passwordReset || !Hash::check($token, $passwordReset->token)) {
            throw ValidationException::withMessages('Invalid token or email.');
        }

        // Check if the token has expired (15 minutes expiration)
        if (Carbon::parse($passwordReset->created_at)->addMinutes(15)->isPast()) {
            return redirect()->route('password.request')->withErrors('This password reset link has expired.');
        }

        // Find the user or administrator and update the password
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = Administrator::where('email', $email)->first();
        }

        if ($user) {
            $user->password = Hash::make($request->input('password'));
            $user->save();
        }

        // Delete the password reset record to prevent reuse
        PasswordReset::where('email', $email)->delete();

        // Redirect to login page with a success message
        return redirect()->route('login')->withSuccess('Password has been successfully reset.');
    }
}
