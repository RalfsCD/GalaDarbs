<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $notifications = $user->notifications()->latest()->get();
        $user->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return back();
    }
}
