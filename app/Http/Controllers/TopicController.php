<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{

   public function index(Request $request)
{
    $search = trim((string) $request->query('search', ''));

    $topics = Topic::query()
        ->withCount('groups')
        ->when($search !== '', function ($q) use ($search) {
            $q->where(function ($qq) use ($search) {
                $qq->where('name', 'like', "%{$search}%")
                   ->orWhere('description', 'like', "%{$search}%");
            });
        })
        ->orderBy('name')
        ->paginate(12)
        ->appends($request->only('search')); // keep ?search= in links

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
