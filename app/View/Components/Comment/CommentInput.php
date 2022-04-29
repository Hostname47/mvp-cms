<?php

namespace App\View\Components\Comment;

use Illuminate\View\Component;
use App\Models\Comment;

class CommentInput extends Component
{
    public $is_root;
    public $parent_comment_id;
    /**
     * If a comment is passed to the constructor; that means the input container is for
     * updating the comment
     */
    public $comment;
    
    public function __construct($root=false, $parentCommentId=null, $comment=null)
    {
        $this->is_root = $root;
        $this->parent_comment_id = $parentCommentId;
        $this->comment = $comment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.comment.comment-input', $data);
    }
}
