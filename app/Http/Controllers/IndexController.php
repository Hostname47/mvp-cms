<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Post};

class IndexController extends Controller
{
    public function index() {
        return view('index');
    }

    public function discover(Request $request) {
        $count = 8;

        $posts = Post::with(['categories', 'author','author.roles', 'tags']);
        
        if($request->has('count')) {
            $count = $request->validate([
                'count'=>'integer|between:8,20'
            ])['count'];
        }

        $posts = Post::orderBy('published_at', 'desc')->with(['categories', 'author','author.roles', 'tags'])->take($count+1)->get();
        $hasmore = $posts->count() > $count;
        $posts = $posts->take($count);

        return view('discover')
            ->with(compact('posts'))
            ->with(compact('count'))
            ->with(compact('hasmore'));
    }
}
