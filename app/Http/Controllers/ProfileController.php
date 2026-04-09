<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $followers = $user->followers()->count();
        $following = $user->following()->count();

        $posts = Post::where('user_id', $user->id)
            ->latest()
            ->paginate(5);

        return view('profile.profile', compact('user', 'followers', 'following', 'posts'));
    }


    public function settings()
    {

    // izsauc profila iestatījumu skatu
        return view('profile.settings', ['user' => Auth::user()]);
    }

    // profila rediģēšanas funkcija
    public function update(Request $request)
    {
        // datu validācija
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:6048',
        ], [
            'profile_photo.image' => 'Profile photo must be an image file (jpg, png, webp, ...).',
            'profile_photo.max' => 'Profile photo is too large. Max allowed size is 2MB.',
        ]);

        // iegūst pašreizējo lietotāju
        $user = $request->user();
        $user->name = $request->name;

        $oldPhotoPath = $user->profile_photo_path;

        try {
            // ja ir augšupielādēts profila foto, tiek saglabāts jaunais
            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile-photos', 'public');

                if (! $path) {
                    return Redirect::back()
                        ->withInput()
                        ->withErrors([
                            'profile_photo' => 'Could not save profile photo. Please check storage permissions and try again.',
                        ]);
                }

                $user->profile_photo_path = $path;
            }

            // saglabā lietotāja izmaiņas
            $user->save();

            // dzēš veco foto tikai pēc veiksmīgas jaunā saglabāšanas
            if ($request->hasFile('profile_photo') && $oldPhotoPath && $oldPhotoPath !== $user->profile_photo_path) {
                Storage::disk('public')->delete($oldPhotoPath);
            }
        } catch (\Throwable $exception) {
            Log::error('Profile update failed', [
                'user_id' => $user->id,
                'message' => $exception->getMessage(),
            ]);

            return Redirect::back()
                ->withInput()
                ->withErrors([
                    'profile_photo' => 'Profile photo upload failed: ' . $exception->getMessage(),
                ]);
        }

        // pāradresē lietotāju uz profila iestatījumu skatu 
        return Redirect::route('profile.settings')->with('status', 'Profile updated!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => 'Your current password is incorrect.',
            'password.confirmed' => 'New password confirmation does not match.',
            'password.min' => 'New password must be at least 8 characters long.',
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        return Redirect::route('profile.settings')->with('status', 'Password updated!');
    }

    // profila dzēšanas funkcija
    public function destroy(Request $request)
    {
        // pārbauda, vai ievadītā parole ir pareiza
        $request->validate(['password' => ['required', 'current_password']]);

        // iegūst pašreizējo lietotāju un iziet no profila
        $user = $request->user();
        Auth::logout();

        // dzēš lietotāja profila foto, ja tāds ir
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // dzēš lietotāju no datu bāzes
        $user->delete();

        // izveido jaunu sesijau un pāradresē uz sākumlapu
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
