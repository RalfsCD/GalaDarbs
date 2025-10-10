<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        // use simple collection; the view handles both paginated and non-paginated
        $news = News::latest()->get();
        return view('news.index', compact('news'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return view('news.create');
        }

        return redirect()->back()->with('error', 'You are not authorized to access this page.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'media'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('media')) {
            // store on the public disk; returns paths like "news/abc123.jpg"
            $path = $request->file('media')->store('news', 'public');
        }

        News::create([
            'title'   => $request->title,
            'content' => $request->content,
            // save exactly what store() returned (e.g. "news/abc123.jpg")
            'image'   => $path,
        ]);

        return redirect()->route('news.index')->with('success', 'News created successfully');
    }
}
