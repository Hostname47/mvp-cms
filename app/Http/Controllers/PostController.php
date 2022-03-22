<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use App\Models\Post;

class PostController extends Controller
{
    public function create() {
        return view('admin.posts.create');
    }

    public function store(Request $request) {
        $postdata = $request->validate([
            'title'=>'required|min:2|max:1200',
            'title_meta'=>'required|min:2|max:1200',
            'slug'=>'required|min:2|max:1200',
            'summary'=>'required|min:2|max:2000',
            'status'=>['sometimes', Rule::in(['draft', 'published', 'under-review'])],
            'visibility'=>['sometimes', Rule::in(['public', 'private', 'password-locked'])],
            'content'=>'required|min:2|max:50000',
        ]);
        $postdata['user_id'] = auth()->user()->id;

        $categories = $request->validate([
            'categories'=>'required|min:1|max:10',
            'categories.*'=>'exists:categories,id',
        ]);

        // Create the post
        $post = Post::create($postdata);

        // Attach categories to the post
        foreach($categories as $category) {
            $post->categories()->attach($category);
        }

        Session::flash('Post created successfully');
    }
}
