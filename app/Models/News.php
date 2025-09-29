<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage; 

class News extends Model
{
    protected $fillable = ['title', 'image', 'content'];
}
