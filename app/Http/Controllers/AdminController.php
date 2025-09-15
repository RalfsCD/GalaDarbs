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
    public function users()
{
    // Eager load warnings for each user
    $users = User::with('warnings')->get();
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
