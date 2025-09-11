<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the topics.
     */
    public function index()
    {
        $topics = Topic::withCount('groups')->latest()->get();

        return view('topics.index', compact('topics'));
    }

    /**
     * Show the form for creating a new topic (admin only).
     */
    public function create()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        return view('topics.create');
    }

    /**
     * Store a newly created topic.
     */
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

    /**
     * Display a single topic with its groups.
     */
    public function show(Topic $topic)
{
    // Load groups and their members
    $topic->load('groups.members', 'groups.topics', 'groups.creator');

    return view('topics.show', compact('topic'));
}
}
