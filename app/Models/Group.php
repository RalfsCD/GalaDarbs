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

    protected $table = 'user_groups'; // explicitly use the renamed table

    protected $fillable = [
        'name',
        'description',
        'creator_id',
    ];

    /**
     * The user who created the group
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Users who are members of this group
     */
    public function members()
    {
        return $this->belongsToMany(
            User::class,
            'group_user',  // pivot table
            'group_id',
            'user_id'
        )->withTimestamps();
    }

    /**
     * Topics associated with this group
     */
    public function topics()
    {
        return $this->belongsToMany(
            Topic::class,
            'group_topic', // pivot table
            'group_id',
            'topic_id'
        )->withTimestamps();
    }

    /**
     * Posts created inside this group
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'group_id');
    }
}
