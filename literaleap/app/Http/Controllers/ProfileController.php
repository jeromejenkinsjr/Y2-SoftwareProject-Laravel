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
use App\Models\ShopItem;



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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:max_width=2000,max_height=2000',
            'crop_x'          => 'nullable|numeric',
            'crop_y'          => 'nullable|numeric',
            'crop_width'      => 'nullable|numeric',
            'crop_height'     => 'nullable|numeric',
            'shop_item_id'    => 'nullable|exists:shop_items,id',
        ]);

        $user = Auth::user();

        // If a shop item is selected, use its image as the profile picture.
        if ($request->filled('shop_item_id')) {
            $shopItemId = $request->input('shop_item_id');
            // Verify that the user owns the selected shop item.
            if ($user->shopItems()->where('shop_item_id', $shopItemId)->exists()) {
                $shopItem = ShopItem::find($shopItemId);
                if ($shopItem) {
                    // Optionally, you might want to process or simply assign the image path.
                    $user->profile_picture = $shopItem->image;
                    $user->save();
                    return Redirect::route('profile.edit')->with('success', 'Profile picture updated successfully.');
                }
            } else {
                return Redirect::route('profile.edit')->with('error', 'Selected shop item not owned.');
            }
        }

        // Otherwise, if a file was uploaded, process it.
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists.
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }

            $file = $request->file('profile_picture');
            $img = Image::read($file->getRealPath());

            // If crop coordinates are provided, crop the image.
            if ($request->filled(['crop_x', 'crop_y', 'crop_width', 'crop_height'])) {
                $cropX = (int) $request->input('crop_x');
                $cropY = (int) $request->input('crop_y');
                $cropWidth = (int) $request->input('crop_width');
                $cropHeight = (int) $request->input('crop_height');
                $img->crop($cropWidth, $cropHeight, $cropX, $cropY);
            }

            // Resize the image to desired final dimensions (e.g., 300x300).
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Create a unique file name and path.
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = 'profile_pictures/' . $fileName;

            // Save the processed image to storage.
            $img->save(storage_path('app/public/' . $path));

            // Update user's profile picture path.
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
    public function register(Request $request)
{
    // Validate the incoming registration data
    $data = $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|string|email|max:255|unique:users',
        'password'        => 'required|string|min:8|confirmed',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // Include any additional fields here...
    ]);

    // Create the new user
    $user = new User();
    $user->name     = $data['name'];
    $user->email    = $data['email'];
    $user->password = Hash::make($data['password']);

    // Process the profile picture upload if provided
    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');

        // For instance, using Intervention Image:
        $img = Image::read($file->getRealPath());
        $img->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Create a unique file name and path
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = 'profile_pictures/' . $fileName;
        $img->save(storage_path('app/public/' . $path));

        // Set the user's profile picture path
        $user->profile_picture = $path;
    } else {
        // If no picture was uploaded (or skipped), assign the default avatar
        $user->profile_picture = 'images/defaultava.jpg';
    }

    $user->save();

    // Log the user in or redirect as needed
    // For example:
    Auth::login($user);
    return redirect()->route('dashboard');
}

}
