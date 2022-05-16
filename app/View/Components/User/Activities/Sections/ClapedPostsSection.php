<?php

namespace App\View\Components\User\Activities\Sections;

use Illuminate\View\Component;

class ClapedPostsSection extends Component
{
    public $posts;

    public function __construct()
    {
        $this->posts = auth()->user()->posts_claped()->with(['categories'])->paginate(10);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.activities.sections.claped-posts-section', $data);
    }
}
