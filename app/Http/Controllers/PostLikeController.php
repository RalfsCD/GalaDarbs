<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Notifications\PostLikedNotification;

class PostLikeController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $userId = $request->user()->id;

        // Toggle like
        $toggled = $post->likes()->toggle($userId);
        $liked = !empty($toggled['attached']);

        $post->loadCount('likes');

        // Send notification to post owner if liked (not self)
        if ($liked && $post->user_id !== $userId) {
            $post->user->notify(
                new PostLikedNotification($request->user()->name, $post->title)
            );
        }

        return response()->json([
            'likes' => $post->likes_count,
            'liked' => $liked,
        ]);
    }
}
