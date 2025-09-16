<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostLikedNotification extends Notification
{
    use Queueable;

    public $userName;
    public $postTitle;

    public function __construct(string $userName, string $postTitle)
    {
        $this->userName = $userName;
        $this->postTitle = $postTitle;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'post_liked',
            'user_name' => $this->userName,
            'post_title' => $this->postTitle,
        ];
    }
}
