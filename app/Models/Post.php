<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // ⬅️ add this

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

    /**
     * Normalized media URL for the /storage symlink.
     * Handles values like:
     *  - "posts/file.png"
     *  - "public/posts/file.png"
     *  - "storage/posts/file.png"
     *  - Windows backslashes "posts\file.png"
     */
    public function getMediaUrlAttribute(): ?string
    {
        if (empty($this->media_path)) {
            return null;
        }

        // Normalize directory separators
        $path = str_replace('\\', '/', (string) $this->media_path);
        $path = ltrim($path, '/');

        // If already "storage/...", return as-is (prefixed with /)
        if (str_starts_with($path, 'storage/')) {
            return '/' . $path;
        }

        // If "public/...", strip the prefix and convert to "/storage/..."
        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7); // drop "public/"
        }

        // Otherwise it's most likely "posts/filename.ext"
        return Storage::url($path);  // -> "/storage/posts/filename.ext"
    }
}
