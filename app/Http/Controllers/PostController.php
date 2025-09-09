<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request, Group $group)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'media' => 'nullable|image|max:2048',
        ]);

        $data['user_id'] = auth()->id();

        if ($request->hasFile('media')) {
            $data['image'] = $request->file('media')->store('posts', 'public');
        }

        $post = $group->posts()->create($data);

        $post->load('user','likes','comments.user');

        // Return JSON with rendered HTML partial
        $html = view('partials.post', compact('post'))->render();
        return response()->json(['html' => $html]);
    }

    public function like(Post $post)
    {
        $user = auth()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->detach($user->id);
        } else {
            $post->likes()->attach($user->id);
        }

        return response()->json(['likes' => $post->likes()->count()]);
    }

    public function comment(Request $request, Post $post)
    {
        $data = $request->validate(['content' => 'required|string|max:1000']);
        $data['user_id'] = auth()->id();
        $comment = $post->comments()->create($data);
        $comment->load('user');

        $html = view('partials.comment', compact('comment'))->render();

        return response()->json([
            'html' => $html,
            'comment_count' => $post->comments()->count(),
        ]);
    }

    public function show(Post $post)
    {
        $post->load('user','group','likes','comments.user');
        return view('posts.show', compact('post'));
    }
} // <-- This closing brace was missing
