<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Comment,Post};
use Illuminate\Validation\Rule;
use App\View\Components\Comment\Comment as CommentComponent;

class CommentController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'content'=>'required|max:4000',
            'post_id'=>'required|exists:posts,id',
        ]);
        $return = $request->validate(['form'=>['sometimes',Rule::in(['component'])]]);
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
        $comment = Comment::create($data);
        /**
         * Here we have to increment the comments counter of post
         */
        $post->increment('comments_count');

        if(isset($return['form']))
            switch($return['form']) {
                case 'component':
                    $comment_component = (new CommentComponent($comment));
                    $comment_component = $comment_component->render(get_object_vars($comment_component))->render();
                    return $comment_component;
            }
    }

    public function fetch(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric',
            'take'=>'required|numeric',
            'sort'=>['required', Rule::in(['newest','oldest','claps'])],
            'form'=>['required', Rule::in(['raw','component'])],
            'id'=>'sometimes|exists:comments,id'
        ]);

        $sortby = '';
        $sdirection = '';
        switch($data['sort']) {
            case 'newest':
                $sortby = 'created_at';
                $sdirection = 'desc';
                break;
            case 'oldest':
                $sortby = 'created_at';
                $sdirection = 'asc';
                break;
            case 'oldest':
                $sortby = 'reactions_count';
                $sdirection = 'desc';
                break;
        }

        $comments = Comment::with('user')->orderBy($sortby, $sdirection)->skip($data['skip'])->take($data['take']+1)->get();
        $hasmore = $comments->count() > $data['take'];
        $comments = $comments->take($data['take']);
        $payload = '';
        switch($data['form']) {
            case 'raw':
                $payload = $comments->map(function($post) {
                    return [
                        'id'=>$post->id,
                        // The other neccessary columns
                    ];
                });
                break;
            case 'component':
                $comments->map(function($comment) use (&$payload) {
                    $comment = (new CommentComponent($comment));
                    $comment = $comment->render(get_object_vars($comment))->render();
                    $payload .= $comment;
                });
                break;
        }

        return [
            'comments'=>$payload,
            'count'=>$comments->count(),
            'hasmore'=>$hasmore
        ];
    }
}
