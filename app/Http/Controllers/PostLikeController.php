<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Notifications\PostLikedNotification;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $userId = $request->user()->id;

        // Toggle like
        $toggled = $post->likes()->toggle($userId);
        $liked = !empty($toggled['attached']);

        $post->loadCount('likes');

        // If liked and not own post, create notification
        if ($liked && $post->user_id !== $userId) {
            $exists = $post->user->notifications()
                ->where('type', PostLikedNotification::class)
                ->where('data->post_id', $post->id)
                ->where('data->user_id', $userId)
                ->exists();

            if (!$exists) {
                $post->user->notify(
                    new PostLikedNotification($request->user(), $post)
                );
            }
        }

        // If unliked, remove existing notification
        if (!$liked && $post->user_id !== $userId) {
            $post->user->notifications()
                ->where('type', PostLikedNotification::class)
                ->where('data->post_id', $post->id)
                ->where('data->user_id', $userId)
                ->delete();
        }

        return response()->json([
            'likes' => $post->likes_count,
            'liked' => $liked,
        ]);
    }
}
