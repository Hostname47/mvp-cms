<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'title'=>'required|min:2|max:1200',
            'title_meta'=>'required|min:2|max:1200',
            'slug'=>'required|min:2|max:1200',
            'content'=>'required|min:2|max:50000',
            'category_id'=>'required|exists:categories,id',
            'state'=>['sometimes', Rule::in(['draft', 'inactive', 'active'])]
        ]);
        $data['user_id'] = auth()->user()->id;

        Post::create($data);
    }

    public function update(Request $request) {
        $data = $request->validate([
            'post_id'=>'required|exists:posts,id',
            'title'=>'sometimes|min:2|max:1200',
            'title_meta'=>'sometimes|min:2|max:1200',
            'slug'=>'sometimes|min:2|max:1200',
            'content'=>'sometimes|min:2|max:50000',
            'category_id'=>'sometimes|exists:categories,id',
        ]);
        $post = Post::find($data['post_id']);
        unset($data['post_id']);
        $post->update($data);
    }
}
