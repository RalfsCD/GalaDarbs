<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string|max:1000',
        ]);

        Report::create([
            'post_id' => $post->id,
            'reported_user_id' => $post->user_id,
            'reporter_id' => auth()->id(),
            'reason' => $request->reason,
            'details' => $request->details,
        ]);

        return back()->with('success', 'Post reported successfully.');
    }

    public function index()
    {
        $reports = Report::with(['post', 'reportedUser', 'reporter'])->latest()->get();
        return view('admin.reports', compact('reports'));
    }

    public function resolve(Report $report)
    {
        $report->update(['resolved' => true]);
        return back()->with('success', 'Report marked as resolved.');
    }
}
