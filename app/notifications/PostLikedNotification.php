<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostLikedNotification extends Notification
{
    use Queueable;

    public $actor;
    public $post;

    public function __construct($actor, $post)
    {
        $this->actor = $actor;
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'post_liked',
            'user_id' => $this->actor->id,
            'user_name' => $this->actor->name,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
        ];
    }
}
