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
        $has_more_replies = false;
        /**
         * If a comment has a parent then we need to get the parent session value and increment it
         * by 1 to get the current comment level.
         * root comments has always value 1 which means the first level
         */
        if($comment->parent_comment_id)
            session()->put("comment-$comment->id", session()->get("comment-$comment->parent_comment_id") + 1);
        else
            session()->put("comment-$comment->id", 1); // root comment is on level 1

        if(session()->get("comment-$comment->id") < self::MAX_LEVELS) {
            if($comment->replies_count > 0) {
                $sortby = '';
                $sdirection = '';
                switch(isset($data['sort']) ? $data['sort'] : null) {
                    case 'newest':
                        $sortby = 'created_at';
                        $sdirection = 'desc';
                        break;
                    case 'oldest':
                        $sortby = 'created_at';
                        $sdirection = 'asc';
                        break;
                    case 'claps':
                        $sortby = 'reactions_count';
                        $sdirection = 'desc';
                        break;
                    default:
                        $sortby = 'created_at';
                        $sdirection = 'desc';
                }
                    
                $replies = $comment->children()->with('user')->orderBy($sortby, $sdirection)->take(self::MAX_CHILDREN)->get();
                $replies_claped = [];
                if(auth()->user())
                    $replies_claped = auth()->user()->claps()->whereIn('clapable_id', $replies->pluck('id')->toArray())->where('clapable_type', 'App\Models\Comment')->pluck('clapable_id')->toArray();
            }
        }
        
        $this->replies = $replies;
        $this->replies_claped = $replies_claped;
        $this->has_more_replies = $comment->replies_count > self::MAX_CHILDREN;
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
