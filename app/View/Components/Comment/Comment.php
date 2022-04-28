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
    const MAX_CHILDREN = 6;
    const MAX_LEVELS = 5;

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
            $has_more_replies = $comment->replies_count > self::MAX_CHILDREN;
            $replies_claped = [];
            if(auth()->user())
                $replies_claped = auth()->user()->claps()->whereIn('clapable_id', $replies->pluck('id')->toArray())->where('clapable_type', 'App\Models\Comment')->pluck('clapable_id')->toArray();
    
        }
        $this->replies = $replies;
        $this->replies_claped = $replies_claped;
        $this->has_more_replies = $has_more_replies;
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
