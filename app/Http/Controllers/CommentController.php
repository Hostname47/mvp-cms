<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Comment,Post};

class CommentController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'content'=>'required|max:4000',
            'post_id'=>'required|exists:posts,id'
        ]);
        /**
         * Here we get the post here because we need it here and in policy. Simply get the post and
         * pass it to the policy for checks
         */
        $post = Post::find($data['post_id']);
        /** Authorize the store action */
        $this->authorize('store', [Comment::class, $data, $post]);
        /** Append authenticated user id into the comment data */
        $data['user_id'] = auth()->user()->id;
        // Then create the comment
        Comment::create($data);
        /**
         * Here we have to increment the comments counter of post
         */
        $post->increment('comments_count');
    }
}
