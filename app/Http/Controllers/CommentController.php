<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'content'=>'required|max:4000',
            'post_id'=>'required|exists:posts,id'
        ]);

        $this->authorize('store', [Comment::class, $data]);
        $data['user_id'] = auth()->user()->id;

        Comment::create($data);
    }
}
