<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
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
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'media' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
    ]);

    
    if ($request->hasFile('media')) {
        $image = $request->file('media');
        $path = $image->storeAs('public/news', $image->getClientOriginalName()); 
    }

    
    $news = News::create([
        'title' => $request->title,
        'content' => $request->content,
        'image' => isset($path) ? str_replace('public/', '', $path) : null, 
    ]);

    return redirect()->route('news.index')->with('success', 'News created successfully');
}
}

