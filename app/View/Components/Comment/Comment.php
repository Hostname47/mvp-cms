<?php

namespace App\View\Components\Comment;

use Illuminate\View\Component;
use App\Models\Comment as CommentModel;

class Comment extends Component
{
    public $comment;
    public $claped;
    public $replies;
    public $replies_claped;
    public $replies_remains;
    const MAX_CHILDREN = 4;
    const MAX_LEVELS = 4;

    public function __construct($comment, $data=[])
    {
        $this->comment = $comment;
        $this->claped = isset($data['claped']) ? $data['claped'] : $comment->claped;

        /**
         * Deal with comment children (replies)
         */
        $replies = collect([]);
        $replies_claped = [];
        $replies_remains = 0;
        /**
         * If a comment has a parent then we need to get the parent session value and increment it
         * by 1 to get the current comment level.
         * root comments has always value 1 which means the first level
         */
        if($comment->parent_comment_id)
            session()->put("comment-$comment->id", session("comment-$comment->parent_comment_id", 0)+1);
        else
            session()->put("comment-$comment->id", 1); // root comment is on level 1

        if(session("comment-$comment->id") < self::MAX_LEVELS) {
            if($comment->replies_count > 0) {
                $order = '';
                switch(isset($data['sort']) ? $data['sort'] : null) {
                    case 'newest':
                        $order = 'created_at desc';
                        break;
                    case 'oldest':
                        $order = 'created_at asc';
                        break;
                    case 'claps':
                        $order = 'reactions_count desc';
                        break;
                    default:
                        $order = 'created_at desc';
                }
                    
                $replies = $comment->children()->with('user')->orderByRaw($order)->take(self::MAX_CHILDREN)->get();
                $replies_claped = [];
                if(auth()->user())
                    $replies_claped = auth()->user()->claps()->whereIn('clapable_id', $replies->pluck('id')->toArray())->where('clapable_type', 'App\Models\Comment')->pluck('clapable_id')->toArray();
            }
        } else
            session()->forget("comment-$comment->id");
        
        $this->replies = $replies;
        $this->replies_claped = $replies_claped;
        $this->replies_remains = $comment->replies_count - $replies->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.comment.comment', $data);
    }
}
