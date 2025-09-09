<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
        use AuthorizesRequests;
    public function store(Request $request, Group $group)
    {
        $validated = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'media'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,mp4,mp3,pdf', 'max:20480'],
        ]);

        $path = $request->file('media')
            ? $request->file('media')->store('posts', 'public')
            : null;

        $post = $group->posts()->create([
            'user_id'    => $request->user()->id,
            'title'      => $validated['title'],
            'content'    => $validated['content'] ?? null,
            'media_path' => $path,
        ]);

        $post->load(['user', 'comments.user', 'likes'])->loadCount(['likes', 'comments']);

        $html = view('partials.post', compact('post'))->render();

        return response()->json(['html' => $html], 201);
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes'])->loadCount(['likes', 'comments']);
        return view('posts.show', compact('post')); // optional
    }

    public function destroy(Post $post, Request $request)
{
    if ($post->user_id !== auth()->id()) {
        abort(403);
    }

    $groupId = $request->input('group_id');
    $post->delete();

    // Redirect to group page
    return redirect("/groups/{$groupId}")
        ->with('success', 'Post deleted successfully.');
}

}
