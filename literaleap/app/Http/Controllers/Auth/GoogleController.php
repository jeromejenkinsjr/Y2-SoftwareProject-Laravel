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
            // dd($googleUser);
            // Check if the user already exists in our database by google_id
            $existingUser = User::where('google_id', $googleUser->getId())->first();

            if ($existingUser) {
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
            // dd('Error: ' . $e->getMessage());
            return redirect('/register')->with('error', 'Failed to login with Google.');
        }
    }
}