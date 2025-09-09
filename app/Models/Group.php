<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Topic;
use App\Models\Post;

class Group extends Model
{
    use HasFactory;

    protected $table = 'user_groups';

    protected $fillable = [
        'name',
        'description',
        'creator_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id')->withTimestamps();
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'group_topic', 'group_id', 'topic_id')->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'group_id');
    }
}
