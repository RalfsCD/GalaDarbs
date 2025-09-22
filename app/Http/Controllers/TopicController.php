<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    
    public function index()
    {
        $topics = Topic::withCount('groups')->latest()->get();

        return view('topics.index', compact('topics'));
    }

    
    public function create()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        return view('topics.create');
    }

    
    public function store(Request $request)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:topics,name',
            'description' => 'nullable|string',
        ]);

        Topic::create($data);

        return redirect()->route('topics.index')->with('success', 'Topic created successfully.');
    }

    
    public function show(Topic $topic)
{
    $topic->load('groups.members', 'groups.topics', 'groups.creator');

    return view('topics.show', compact('topic'));
}
}
