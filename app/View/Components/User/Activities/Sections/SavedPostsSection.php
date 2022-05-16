<?php

namespace App\View\Components\User\Activities\Sections;

use Illuminate\View\Component;

class SavedPostsSection extends Component
{
    public $posts;

    public function __construct()
    {
        $this->posts = auth()->user()->posts_saved()->with(['categories'])->paginate(10);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user.activities.sections.saved-posts-section');
    }
}
