<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('about');
    }

    public function news()
    {
        return view('news');
    }

    public function groups()
    {
        return view('groups');
    }

    public function topics()
    {
        return view('topics');
    }
}
