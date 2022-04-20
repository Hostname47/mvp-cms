<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class IndexController extends Controller
{
    public function index() {
        return view('index');
    }

    public function discover() {
        $perpage = 10;
        $posts = Post::orderBy('published_at', 'desc')->with(['categories', 'author','author.roles'])->take($perpage+1)->get();
        $hasmore = $posts->count() > $perpage;
        $posts = $posts->take($perpage);

        return view('discover')
            ->with(compact('posts'))
            ->with(compact('hasmore'));
    }
}
