<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PageController extends Controller
{
    public function dashboard()
    {
        if(auth()->check()) {
            $user = auth()->user();

            // Get posts from groups the user has joined
            $posts = Post::whereIn('group_id', $user->joinedGroups()->pluck('user_groups.id'))
                        ->with('user','group','likes','comments.user')
                        ->latest()
                        ->paginate(10);

            // Get the groups the user has joined for the sidebar
            $joinedGroups = $user->joinedGroups()->get();

            return view('dashboard', compact('posts', 'joinedGroups'));
        }

        // Not logged in -> welcome page
        return view('welcome');
    }

    public function about()
    {
        return view('about');
    }
}
