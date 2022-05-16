<?php

namespace App\View\Components\User\Activities\Sections;

use Illuminate\View\Component;

class CommentsSection extends Component
{
    public $comments;
    
    public function __construct()
    {
        $this->comments = auth()->user()->comments()->with(['post', 'post.categories'])
            ->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user.activities.sections.comments-section');
    }
}
