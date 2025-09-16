<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostCommentedNotification extends Notification
{
    use Queueable;

    public $postTitle;
    public $userName;

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
            'type' => 'post_commented',
            'user_name' => $this->userName,
            'post_title' => $this->postTitle,
        ];
    }
}
