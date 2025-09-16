<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Notification;
use App\Models\Warning;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Main admin index - only unsolved reports
    public function index()
    {
        $unsolvedReports = Report::with(['post', 'reportedUser', 'reporter'])
                            ->where('resolved', false)
                            ->latest()
                            ->get();

        return view('admin.index', compact('unsolvedReports'));
    }

    // All reports page
    public function reports()
    {
        $reports = Report::with(['post', 'reportedUser', 'reporter'])
                         ->latest()
                         ->get();

        return view('admin.reports', compact('reports'));
    }

    // Users page
    public function users(Request $request)
    {
        $query = User::with('warnings');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->sort) {
            switch ($request->sort) {
                case 'warnings_desc':
                    $query->withCount('warnings')->orderBy('warnings_count', 'desc');
                    break;
                case 'warnings_asc':
                    $query->withCount('warnings')->orderBy('warnings_count', 'asc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
            }
        }

        $users = $query->paginate(10);

        return view('admin.users', compact('users'));
    }

    // Delete user
    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin accounts.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    // Delete post (from PostController logic if deleting as admin)
    public function deletePostAsAdmin($post)
    {
        $postModel = \App\Models\Post::findOrFail($post);
        $postModel->delete();

        // Create warning
        Warning::create([
            'user_id' => $postModel->user_id,
            'post_id' => $postModel->id,
            'reason' => 'Post deleted by admin',
        ]);

        // Create notification
        Notification::create([
            'user_id' => $postModel->user_id,
            'type' => 'post_reported',
            'data' => [
                'post_id' => $postModel->id,
                'post_title' => $postModel->title,
            ],
        ]);

        return redirect()->route('admin.index')->with('success', 'Post deleted and user notified.');
    }
}
