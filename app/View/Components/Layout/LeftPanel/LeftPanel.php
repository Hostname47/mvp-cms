<?php

namespace App\View\Components\Layout\LeftPanel;

use Illuminate\View\Component;
use App\Models\{Category,Tag};

class LeftPanel extends Component
{
    public $categories;
    public $tags;

    public function __construct()
    {
        $this->categories = Category::tree()->get()->toTree();
        $this->tags = Tag::withCount('posts')
            ->withCount('posts as posts_count')
            ->orderByRaw('posts_count DESC')
            ->take(12)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.left-panel.left-panel');
    }
}
