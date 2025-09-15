<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    // Show all users
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.index', compact('users'));
    }

    // Delete a user
    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'You cannot delete another admin.');
        }

        $user->delete();
        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }
}
