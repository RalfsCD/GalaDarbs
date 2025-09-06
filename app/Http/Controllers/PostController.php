<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request, Group $group) {
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'content'=>'required|string',
            'image'=>'nullable|image|max:2048',
        ]);

        if($request->hasFile('image')) {
            $data['image']=$request->file('image')->store('posts','public');
        }

        $data['user_id']=auth()->id();
        $data['group_id']=$group->id;

        Post::create($data);
        return back()->with('success','Post created!');
    }

    public function like(Post $post)
{
    $post->likes()->syncWithoutDetaching(auth()->id());
    return back();
}

    public function comment(Request $request, Post $post) {
        $request->validate(['content'=>'required|string']);
        $post->comments()->create([
            'content'=>$request->content,
            'user_id'=>auth()->id(),
        ]);
        return back();
    }
}
