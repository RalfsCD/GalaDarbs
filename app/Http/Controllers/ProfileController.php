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

    // izsauc profila iestatījumu skatu
        return view('profile.settings', ['user' => Auth::user()]);
    }

    // profila rediģēšanas funkcija
    public function update(Request $request)
    {
        // datu validācija
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        // iegūst pašreizējo lietotāju
        $user = $request->user();
        $user->name = $request->name;

        // ja ir augšupielādēts profila foto, tiek izdzēsts vecais un saglabāts jaunais
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        // saglabā lietotāja izmaiņas
        $user->save();

        // pāradresē lietotāju uz profila iestatījumu skatu 
        return Redirect::route('profile.settings')->with('status', 'Profile updated!');
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
