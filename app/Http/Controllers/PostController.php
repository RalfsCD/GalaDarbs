<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request, Group $group)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'media' => 'nullable|image|max:2048',
        ]);

        if($request->hasFile('media')){
            $data['image'] = $request->file('media')->store('posts','public');
        }

        $post = $group->posts()->create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => $data['image'] ?? null,
        ]);

        $post->load('user','comments.user','likes');

        $html = view('partials.post', ['post' => $post])->render();

        return response()->json(['html' => $html]);
    }

    public function like(Post $post)
    {
        $post->likes()->syncWithoutDetaching(auth()->id());
        return response()->json(['likes' => $post->likes()->count()]);
    }

    public function comment(Request $request, Post $post)
    {
        $data = $request->validate(['content'=>'required|string|max:1000']);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $data['content'],
        ]);

        $comment->load('user');

        $html = view('partials.comment', ['comment' => $comment])->render();

        return response()->json([
            'html' => $html,
            'comment_count' => $post->comments()->count()
        ]);
    }

    public function destroy(Post $post)
    {
        if($post->user_id !== auth()->id()){
            return response()->json(['error'=>'Unauthorized'],403);
        }

        $post->delete();

        return response()->json(['success'=>true]);
    }
}
