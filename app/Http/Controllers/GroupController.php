<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Topic;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('creator', 'members', 'topics')->get();
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        $topics = Topic::all();
        return view('groups.create', compact('topics'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'topics' => 'nullable|array',
            'topics.*' => 'exists:topics,id',
        ]);

        $group = Group::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'creator_id' => auth()->id(),
        ]);

        if (!empty($data['topics'])) {
            $group->topics()->sync($data['topics']);
        }

        $group->members()->attach(auth()->id());

        return redirect()->route('groups.index')->with('success', 'Group created successfully!');
    }

    public function join(Group $group)
    {
        $group->members()->syncWithoutDetaching(auth()->id());
        return back();
    }

    public function leave(Group $group)
    {
        $group->members()->detach(auth()->id());
        return back();
    }

    // Show group with posts (AJAX sort support)
    public function show(Request $request, Group $group)
    {
        $sort = $request->get('sort', 'newest');

        $postsQuery = $group->posts()->with('user','comments.user','likes');

        if($sort === 'newest') {
            $postsQuery->latest();
        } elseif($sort === 'oldest') {
            $postsQuery->oldest();
        } elseif($sort === 'most_liked') {
            $postsQuery->withCount('likes')->orderByDesc('likes_count');
        }

        $posts = $postsQuery->get();

        if($request->ajax()){
            $html = '';
            foreach($posts as $post){
                $html .= view('partials.post', ['post' => $post])->render();
            }
            return response()->json(['html' => $html]);
        }

        $group->load('creator','members','topics','posts.user','posts.comments.user','posts.likes');

        return view('groups.show', compact('group'));
    }
}
