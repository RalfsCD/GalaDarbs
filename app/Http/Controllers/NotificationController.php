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

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        if (
            $notification->notifiable_id !== auth()->id()
            || $notification->notifiable_type !== get_class(auth()->user())
        ) {
            abort(403);
        }

        $notification->markAsRead();

        return back();
    }
}
