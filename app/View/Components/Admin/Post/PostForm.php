<?php

namespace App\View\Components\Admin\Post;

use Illuminate\View\Component;

class PostForm extends Component
{
    public $post;
    public function __construct($post=null)
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
        return view('components.admin.post.post-form', $data);
    }
}
