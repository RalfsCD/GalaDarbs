<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title','content','user_id','group_id','image'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function group() {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        // Specify the pivot table name 'likes'
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
    }
}
