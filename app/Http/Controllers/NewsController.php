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
    // Validate the request data
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'media' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Add validation for image files
    ]);

    // Handle the file upload for the image
    if ($request->hasFile('media')) {
        $image = $request->file('media');
        $path = $image->storeAs('public/news', $image->getClientOriginalName()); // Save image in public/news folder
    }

    // Create the news entry in the database
    $news = News::create([
        'title' => $request->title,
        'content' => $request->content,
        'image' => isset($path) ? str_replace('public/', '', $path) : null, // Store the image path without the "public/" prefix
    ]);

    return redirect()->route('news.index')->with('success', 'News created successfully');
}
}

