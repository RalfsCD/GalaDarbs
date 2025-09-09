<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','email','password','profile_photo_path','role'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at'=>'datetime'];

    // Groups created by this user
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user');  // pivot table
    }


    // Groups this user joined
    public function joinedGroups()
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followed_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
