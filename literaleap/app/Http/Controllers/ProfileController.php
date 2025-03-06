<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Validate name and email
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's profile picture with cropping.
     */
    public function updateProfilePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max file size: 2MB
            // Optionally you can enforce maximum dimensions on the uploaded file
            'profile_picture' => 'dimensions:max_width=2000,max_height=2000',
            'crop_x'   => 'nullable|numeric',
            'crop_y'   => 'nullable|numeric',
            'crop_width'  => 'nullable|numeric',
            'crop_height' => 'nullable|numeric',
        ]);

        $user = Auth::user();

        // If a file was uploaded, process it
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if it exists
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }

            $file = $request->file('profile_picture');
            $img = Image::read($file->getRealPath());

            // If crop coordinates were provided, crop the image
            if ($request->filled(['crop_x', 'crop_y', 'crop_width', 'crop_height'])) {
                $cropX = (int) $request->input('crop_x');
                $cropY = (int) $request->input('crop_y');
                $cropWidth = (int) $request->input('crop_width');
                $cropHeight = (int) $request->input('crop_height');
                $img->crop($cropWidth, $cropHeight, $cropX, $cropY);
            }

            // (Optional) Resize the image to desired final dimensions (e.g., 300x300)
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Define a unique file name and path
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = 'profile_pictures/' . $fileName;

            // Save the processed image to storage
            $img->save(storage_path('app/public/' . $path));

            // Update user's profile picture path
            $user->profile_picture = $path;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('success', 'Profile picture updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete profile picture if it exists
        if ($user->profile_picture) {
            Storage::delete('public/' . $user->profile_picture);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
