<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Comment,Post};
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use App\View\Components\Comment\Comment as CommentComponent;

class CommentController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'content'=>'required|max:4000',
            'post_id'=>'required|exists:posts,id',
            'parent_comment_id'=>'sometimes|exists:comments,id'
        ]);
        $return = $request->validate(['form'=>['sometimes', Rule::in(['component'])]]);
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
         * Here we have to increment the comments counter of post; Notice that we don't want 
         * updated_at column of post to be updated in that case
         */
        $post->timestamps = false;
        $post->increment('comments_count');
        /**
         * If the comment is a child comment then we have to increment the parent's replies count
         */
        if(isset($data['parent_comment_id'])) {
            $parent = Comment::find($data['parent_comment_id']);
            if($parent) {
                $parent->timestamps = false;
                $parent->increment('replies_count');
            }
        }

        if(isset($return['form']))
            switch($return['form']) {
                case 'component':
                    $comment_component = (new CommentComponent($comment));
                    $comment_component = $comment_component->render(get_object_vars($comment_component))->render();
                    return $comment_component;
            }
    }

    public function update(Request $request) {
        $data = $request->validate([
            'comment_id'=>'required|exists:comments,id',
            'content'=>'sometimes|max:4000',
        ]);

        $comment = Comment::find($data['comment_id']);
        abort_if(is_null($comment), 404, __('Oops something went wrong.'));
        $post = $comment->post;
        abort_if(is_null($post), 404, __('Oops something went wrong.'));

        $this->authorize('update', [Comment::class, $comment]);
        $comment->update(['content'=>$data['content']]);
    }

    public function fetch(Request $request) {
        $data = $request->validate([
            'post_id'=>'required|exists:posts,id',
            'skip'=>'required|numeric',
            'take'=>'required|numeric',
            'sort'=>['required', Rule::in(['newest','oldest','claps'])],
            'form'=>['required', Rule::in(['raw','component'])],
            'id'=>'sometimes|exists:comments,id'
        ]);

        $order = '';
        switch($data['sort']) {
            case 'newest':
                $order = 'created_at desc';
                break;
            case 'oldest':
                $order = 'created_at asc';
                break;
            case 'claps':
                $order = 'reactions_count desc, created_at desc';
                break;
        }

        $post = Post::find($data['post_id']);
        if(!$post)
            abort(404, __('Oops something went wrong.'));

        $comments = $post->comments()->whereNull('parent_comment_id')->with('user')->orderByRaw($order)->skip($data['skip'])->take($data['take']+1)->get();
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
                /**
                 * Here instead of checking each comment whether it is claped by the current user, we
                 * get all claps of the current user on all $comments and return their clapable_id as array
                 * then we check for every comment if its id exists is claps array; If qso then the current user
                 * already claped the comment; and we end up with only one query instead of checking the current
                 * user clap for every single comment (n queries)
                 */
                $claped = [];
                if(auth()->user())
                    $claped = auth()->user()->claps()->whereIn('clapable_id', $comments->pluck('id')->toArray())->where('clapable_type', 'App\Models\Comment')->pluck('clapable_id')->toArray();
                $comments->map(function($comment) use (&$payload, $claped, $data) {
                    $comment = new CommentComponent($comment, [
                        'claped'=>in_array($comment->id, $claped), 'sort'=>$data['sort']
                    ]);
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

    public function replies(Request $request) {
        $data = $request->validate([
            'comment_id'=>'required|exists:posts,id',
            'skip'=>'required|numeric',
            'take'=>'required|numeric',
            'sort'=>['required', Rule::in(['newest','oldest','claps'])],
            'form'=>['required', Rule::in(['raw','component'])],
        ]);

        $comment = Comment::find($data['comment_id']);
        if(!$comment) abort(404, __('Oops something went wrong.'));

        $order = $this->validate_sort($data['sort']);

        $replies = $comment->children()->with('user')->orderByRaw($order)->skip($data['skip'])->take($data['take']+1)->get();
        $hasmore = $replies->count() > $data['take'];
        $replies = $replies->take($data['take']);

        $payload = '';
        switch($data['form']) {
            case 'component':
                $claped = [];
                if(auth()->user())
                    $claped = auth()->user()->claps()->whereIn('clapable_id', $replies->pluck('id')->toArray())->where('clapable_type', 'App\Models\Comment')->pluck('clapable_id')->toArray();
                $replies->map(function($reply) use (&$payload, $claped, $data) {
                    $reply = new CommentComponent($reply, [
                        'claped'=>in_array($reply->id, $claped), 'sort'=>$data['sort']
                    ]);
                    $reply = $reply->render(get_object_vars($reply))->render();
                    $payload .= $reply;
                });
                break;
        }

        return [
            'replies'=>$payload,
            'count'=>$replies->count(),
            'hasmore'=>$hasmore
        ];
    }

    private function validate_sort($sort) {
        $order='';
        switch($sort) {
            case 'newest':
                $order = 'created_at desc';
                break;
            case 'oldest':
                $order = 'created_at asc';
                break;
            case 'claps':
                $order = 'reactions_count desc, created_at desc';
                break;
        }

        return $order;
    }
}
