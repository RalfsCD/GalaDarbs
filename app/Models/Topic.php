<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['name', 'description'];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_topic');
    }
}
