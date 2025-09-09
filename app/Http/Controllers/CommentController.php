<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $data['content'],
        ]);

        $comment->load('user');
        $post->loadCount('comments');

        $html = view('partials.comment', compact('comment'))->render();

        return response()->json([
            'html'          => $html,
            'comment_count' => $post->comments_count,
        ]);
    }
}
