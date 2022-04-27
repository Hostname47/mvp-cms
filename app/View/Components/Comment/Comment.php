<?php

namespace App\View\Components\Comment;

use Illuminate\View\Component;
use App\Models\Comment as CommentModel;

class Comment extends Component
{
    public $comment;
    public $claped;

    public function __construct(CommentModel $comment, $data=[])
    {
        $this->comment = $comment;
        $this->claped = isset($data['claped']) ? $data['claped'] : $comment->claped;
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
