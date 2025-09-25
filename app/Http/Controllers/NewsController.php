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
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect()->back()->with('error', 'You are not authorized to perform this action.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('news.index')->with('success', 'News published!');
    }
}
