<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Purifier;

class SearchController extends Controller
{
    public function search(Request $request) {
        $k = null;
        $posts = collect([]);
        $authors = collect([]);
        $tags = collect([]);

        if($request->has('k')) {
            // protect against xss
            $k = $request->get('k');

            // get tags
            // get authors
            // get posts
        }

        return view('search.search')
            ->with(compact('k'));
    }
}
