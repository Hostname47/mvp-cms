<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use App\Models\{Post,Category};

class PostController extends Controller
{
    public function create() {
        $root_categories = Category::whereNull('parent_category_id')->orderBy('priority', 'asc')->get();
        return view('admin.posts.create')
            ->with(compact('root_categories'));
    }

    public function store(Request $request) {
        $postdata = $request->validate([
            'title'=>'required|max:1200',
            'title_meta'=>'required|max:1200',
            'slug'=>'required|max:1200',
            'summary'=>'sometimes|max:2000',
            'status'=>['sometimes', Rule::in(['draft', 'published', 'awaiting-review'])],
            'visibility'=>['sometimes', Rule::in(['public', 'private', 'password-locked'])],
            'content'=>'required|max:50000',
            'allow_reactions'=>['sometimes', Rule::in([0, 1])],
            'allow_comments'=>['sometimes', Rule::in([0, 1])],
        ]);
        $postdata['user_id'] = auth()->user()->id;

        $categories = $request->validate([
            'categories'=>'sometimes|min:1|max:10',
            'categories.*'=>'exists:categories,id',
        ]);

        // Create the post
        $post = Post::create($postdata);

        // Attach categories to the post
        foreach($categories as $category) {
            $post->categories()->attach($category);
        }

        Session::flash('message', 'Post has been created successfully. <a href="" class="link-style">click here</a> to see the post');
    }
}
