<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\Warning;
use Illuminate\Http\Request;
use App\Notifications\PostDeletedNotification;

class PostController extends Controller
{
    public function create(Group $group)
    {
        return view('posts.create', compact('group'));
    }

    public function store(Request $request, Group $group)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mp3,pdf|max:20480',
        ]);

        $path = $request->file('media') ? $request->file('media')->store('posts', 'public') : null;

        $post = $group->posts()->create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'media_path' => $path,
        ]);

        return redirect()->route('groups.show', $group)->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'group', 'comments.user', 'likes'])->loadCount(['likes', 'comments']);
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        $isAdmin = auth()->check() && auth()->user()->isAdmin();

        if (auth()->id() !== $post->user_id && !$isAdmin) {
            abort(403, 'Unauthorized');
        }

        if ($isAdmin && auth()->id() !== $post->user_id) {
            Warning::create([
                'user_id' => $post->user_id,
                'post_id' => $post->id,
                'reason' => 'Post deleted by admin',
            ]);

            $post->user->notify(new PostDeletedNotification($post->title));
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }
}
