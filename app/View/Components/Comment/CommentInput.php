<?php

namespace App\View\Components\Comment;

use Illuminate\View\Component;
use App\Models\Comment;

class CommentInput extends Component
{
    public $is_root;
    
    public function __construct($root=false)
    {
        $this->is_root = $root;
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
