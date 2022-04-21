<?php

namespace App\View\Components\Post;

use Illuminate\View\Component;
use App\Models\Post;

class PostCard extends Component
{
    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.post.post-card', $data);
    }
}
