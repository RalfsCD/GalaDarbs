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

            // Get all posts from groups the user has joined
            $posts = Post::whereIn('group_id', $user->joinedGroups()->pluck('user_groups.id'))
                        ->with(['user', 'group', 'likes', 'comments.user'])
                        ->latest()
                        ->get(); // ✅ load all posts, not paginate

            // Get the groups the user has joined for the sidebar
            $joinedGroups = $user->joinedGroups()->with('topics','members')->get();

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
