<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Topic;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    // Display all groups, optionally filtered by topic
    public function index(Request $request)
    {
        $topics = Topic::all();

        $query = Group::with('creator', 'members', 'topics');

        if ($request->has('topic')) {
            $topicId = $request->get('topic');
            $query->whereHas('topics', function ($q) use ($topicId) {
                $q->where('topics.id', $topicId);
            });
        }

        $groups = $query->get();

        return view('groups.index', compact('groups', 'topics'));
    }

    // Show create group form
    public function create()
    {
        $topics = Topic::all();
        return view('groups.create', compact('topics'));
    }

    // Store a new group
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

    public function show(Group $group)
    {
        $group->load('creator', 'members', 'topics', 'posts.user', 'posts.likes', 'posts.comments.user');
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
