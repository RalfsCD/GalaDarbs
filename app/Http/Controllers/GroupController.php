<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $groups = Group::with('topics')->get();

        // If there is a topic filter
        if ($request->has('topic')) {
            $groups = $groups->filter(function ($group) use ($request) {
                return $group->topics->pluck('id')->contains($request->topic);
            });
        }

        $topics = Topic::all();

        return view('groups.index', compact('groups', 'topics'));
    }

    public function create()
    {
        $topics = Topic::all(); // Assuming you have topics to select from
        return view('groups.create', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'topics' => 'required|array'
        ]);

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'creator_id' => Auth::id(),
        ]);

        $group->topics()->attach($request->topics); // Attach selected topics

        // Add the creator to the group
        $group->members()->attach(Auth::id());

        return redirect()->route('groups.show', $group);
    }

    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    public function join(Group $group)
    {
        $group->members()->attach(Auth::id());
        return redirect()->route('groups.show', $group);
    }

    public function leave(Group $group)
    {
        $group->members()->detach(Auth::id());
        return redirect()->route('groups.show', $group);
    }
}
