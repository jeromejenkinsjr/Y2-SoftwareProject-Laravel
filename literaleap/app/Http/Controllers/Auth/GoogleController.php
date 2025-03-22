<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        // Redirect the user to Google's OAuth page
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        // Obtain the user information from Google
        $googleUser = Socialite::driver('google')->stateless()->user();

        // First check if a user exists by email
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            // If the user exists but doesn't have a google_id, update it
            if (!$existingUser->google_id) {
                $existingUser->update(['google_id' => $googleUser->getId()]);
            }
            // Log in the existing user
            Auth::login($existingUser);
        } else {
            // Register a new user with Google account info
            $newUser = User::create([
                'name'       => $googleUser->getName(),
                'email'      => $googleUser->getEmail(),
                'google_id'  => $googleUser->getId(),
                'password'   => bcrypt(str()->random(16)), 
            ]);
            Auth::login($newUser);
        }

        // Redirect to dashboard
        return redirect()->intended('/dashboard');
    } catch (Exception $e) {
        // Handle errors
        dd('Error: ' . $e->getMessage());
        return redirect('/register')->with('error', 'Failed to login with Google.');
    }
} 
}