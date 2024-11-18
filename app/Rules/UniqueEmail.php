<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\User;
use App\Models\Administrator;

class UniqueEmail implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the email exists in the users table
        $userExists = User::where('email', $value)->exists();

        // Check if the email exists in the administrators table
        $adminExists = Administrator::where('email', $value)->exists();

        // Return false if the email exists in either table
        return !$userExists && !$adminExists;
    }

    public function message()
    {
        return 'The email has already been taken.';
    }
}
