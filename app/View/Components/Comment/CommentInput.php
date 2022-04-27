<?php

namespace App\View\Components\Comment;

use Illuminate\View\Component;
use App\Models\Comment;

class CommentInput extends Component
{
    public $is_root;
    public $parent_comment_id;
    
    public function __construct($root=false, $parentCommentId=null)
    {
        $this->is_root = $root;
        $this->parent_comment_id = $parentCommentId;
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
