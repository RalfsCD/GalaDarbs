<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index(Request $request)
{
    $topicId = $request->query('topic');
    $search  = $request->query('search');

    $groups = Group::query()
        ->with(['topics', 'creator', 'members'])
        ->when($topicId, fn($q) =>
            $q->whereHas('topics', fn($qq) => $qq->where('topics.id', $topicId))
        )
        ->when($search, fn($q) =>
            $q->where('name', 'like', '%' . $search . '%')
        )
        ->get();

    $topics = Topic::all();

    return view('groups.index', compact('groups', 'topics'));
}


    public function create()
    {
        $topics = Topic::all();
        return view('groups.create', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'topics'      => 'required|array',
            'topics.*'    => 'exists:topics,id',
        ]);

        $group = Group::create([
            'name'        => $request->name,
            'description' => $request->description,
            'creator_id'  => Auth::id(),
        ]);

        $group->topics()->attach($request->topics);
        $group->members()->syncWithoutDetaching([Auth::id()]);

        return redirect()->route('groups.show', $group);
    }

    public function show(Request $request, Group $group)
    {
        $sort = $request->get('sort', 'newest');

        $query = $group->posts()
            ->with(['user', 'comments.user', 'likes'])
            ->withCount(['likes', 'comments']);

        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'most_liked':
                $query->orderByDesc('likes_count')->latest();
                break;
            default:
                $query->latest();
        }

        $posts = $query->get();

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('partials.posts', compact('posts'))->render();
            return response()->json(['html' => $html]);
        }

        return view('groups.show', compact('group', 'posts'));
    }

    public function join(Group $group)
    {
        $group->members()->syncWithoutDetaching([Auth::id()]);
        return redirect()->route('groups.show', $group);
    }

    public function leave(Group $group)
    {
        $group->members()->detach(Auth::id());
        return redirect()->route('groups.show', $group);
    }
}
