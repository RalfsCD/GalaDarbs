<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            ->appends($request->only('search'));

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
            'name'        => ['required','string','max:255','unique:topics,name'],
            'description' => ['nullable','string','max:300'],
        ]);

        Topic::create($data);

        return redirect()->route('topics.index')->with('success', 'Topic created successfully.');
    }

    public function show(Topic $topic)
    {
        $topic->load('groups.members', 'groups.topics', 'groups.creator');

        return view('topics.show', compact('topic'));
    }

    /** NEW: Edit page (admin only) */
    public function edit(Topic $topic)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            return redirect()->route('topics.index')->with('error', 'Unauthorized.');
        }

        return view('topics.edit', compact('topic'));
    }

    /** NEW: Update (admin only) */
    public function update(Request $request, Topic $topic)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            return redirect()->route('topics.index')->with('error', 'Unauthorized.');
        }

        $data = $request->validate([
            'name'        => ['required','string','max:255', Rule::unique('topics', 'name')->ignore($topic->id)],
            'description' => ['nullable','string','max:300'],
        ]);

        $topic->update($data);

        return redirect()->route('topics.index')->with('success', 'Topic updated successfully.');
    }

    /** NEW: Destroy (admin only) */
    public function destroy(Topic $topic)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            return redirect()->route('topics.index')->with('error', 'Unauthorized.');
        }

        $topic->delete();

        return redirect()->route('topics.index')->with('success', 'Topic deleted successfully.');
    }
}
