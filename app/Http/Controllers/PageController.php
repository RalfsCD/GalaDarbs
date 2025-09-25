<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PageController extends Controller
{
    public function dashboard(Request $request)
    {
        // If logged in, only show posts from groups user has joined
        if ($request->user()) {
            $joinedGroupIds = $request->user()->groups()->pluck('user_groups.id'); // adjust to your table

            $posts = Post::with(['user', 'group', 'likes', 'comments'])
                ->whereIn('group_id', $joinedGroupIds)
                ->latest()
                ->paginate(10);

            $joinedGroups = $request->user()->groups()->with('topics')->get();
        } else {
            // If not logged in, don’t show posts
            $posts = collect();
            $joinedGroups = collect();
        }

        // Handle infinite scroll
        if ($request->ajax()) {
            return view('partials.post-card-list', compact('posts'))->render();
        }

        return view('dashboard', compact('posts', 'joinedGroups'));
    }

    public function about()
    {
        return view('about');
    }
}
