<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PostDeletedNotification extends Notification
{
    use Queueable;

    public $postTitle;

    public function __construct(string $postTitle)
    {
        $this->postTitle = $postTitle;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'post_deleted',
            'post_title' => $this->postTitle,
        ];
    }
}
