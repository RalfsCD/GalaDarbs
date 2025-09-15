<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
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

    // Search
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
        });
    }

    // Sort
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
}
