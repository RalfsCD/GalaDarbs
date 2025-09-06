<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Group;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request, Group $group)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $group->posts()->create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
            'image' => $data['image'] ?? null,
        ]);

        return back();
    }

    public function like(Post $post)
    {
        $post->likes()->syncWithoutDetaching(auth()->id());
        return back();
    }

    public function comment(Request $request, Post $post)
    {
        $data = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $data['content'],
        ]);

        return back();
    }
}
