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

    // Correctly sync multiple topics
    if (!empty($data['topics'])) {
        $group->topics()->sync($data['topics']); // Laravel will insert one row per topic automatically
    }

    // Add creator as first member
    $group->members()->attach(auth()->id());

    return redirect()->route('groups.index')->with('success', 'Group created successfully!');
}

    public function show(Group $group)
    {
        $group->load('creator', 'members', 'topics', 'posts.user', 'posts.comments.user', 'posts.likes');
        return view('groups.show', compact('group'));
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
}
