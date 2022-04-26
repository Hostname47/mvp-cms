<?php

namespace App\View\Components\Comment;

use Illuminate\View\Component;
use App\Models\Comment as CommentModel;

class Comment extends Component
{
    public $comment;

    public function __construct(CommentModel $comment)
    {
        $this->comment = $comment;
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
