<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'post_id',
        'reported_user_id',
        'reporter_id',
        'reason',
        'details',
        'resolved'
    ];


    public function post()
    {
        return $this->belongsTo(Post::class)->withDefault([
            'title' => '[Deleted]',
            'id' => null
        ]);
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
