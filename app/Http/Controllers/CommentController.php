<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        $post->load(['comments.user']); 

        return response()->json([
            'comments' => $post->comments->map(fn($c) => [
                'id' => $c->id,
                'content' => $c->content,
                'created_at' => $c->created_at->diffForHumans(),
                'user' => [
                    'name' => $c->user->name,
                    'profile_photo_path' => $c->user->profile_photo_path,
                ]
            ])
        ]);
    }

    public function store(Request $request, Post $post)
    {
        $rateKey = sprintf('comment:%d:%s', $post->id, $request->user()?->id ?? $request->ip());

        if (RateLimiter::tooManyAttempts($rateKey, 6)) {
            $seconds = RateLimiter::availableIn($rateKey);

            throw ValidationException::withMessages([
                'content' => "You're commenting too fast. Please wait {$seconds} seconds.",
            ]);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        RateLimiter::hit($rateKey, 60);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
        ]);

        $comment->load('user');

        return response()->json([
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => [
                    'name' => $comment->user->name,
                    'profile_photo_path' => $comment->user->profile_photo_path,
                ]
            ],
            'comments' => $post->comments()->count(),
        ]);
    }
}
