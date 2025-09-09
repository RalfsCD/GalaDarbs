<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Group;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'title',
        'content',
        'image',
    ];

    /**
     * The user who created the post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The group the post belongs to
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Likes for this post
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Comments on the post
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
