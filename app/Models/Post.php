<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; 

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id', 'user_id', 'title', 'content', 'media_path',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
    }

    public function getMediaUrlAttribute(): ?string
    {
        if (empty($this->media_path)) {
            return null;
        }

        $path = str_replace('\\', '/', (string) $this->media_path);
        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            return '/' . $path;
        }

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7); 
        }

        return Storage::url($path);  
    }
}
