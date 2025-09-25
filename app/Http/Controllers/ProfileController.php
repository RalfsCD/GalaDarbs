<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

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
        return view('profile.settings', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $user = $request->user();
        $user->name = $request->name;

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return Redirect::route('profile.settings')->with('status', 'Profile updated!');
    }

    public function destroy(Request $request)
    {
        $request->validate(['password' => ['required', 'current_password']]);

        $user = $request->user();
        Auth::logout();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
