<?php

namespace App\View\Components\User\Activities\Sections;

use Illuminate\View\Component;
use App\Models\{Comment,Post};

class CommentsSection extends Component
{
    public $comments;
    public $stats;
    
    public function __construct()
    {
        $stats = auth()->user()->comments()
            ->select(\DB::raw("MAX(id) as id, COUNT(id) as count"))
            ->groupBy('post_id')->paginate(10);
        
        $this->comments = Comment::whereIn('id', $stats->pluck('id'))
            ->with(['post', 'post.categories'])
            ->orderBy('id', 'desc')->get();
        $this->stats = $stats;
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
