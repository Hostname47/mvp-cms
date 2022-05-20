<?php

namespace App\View\Components\Layout\LeftPanel;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use App\Models\{Category,Tag};

class LeftPanel extends Component
{
    public $page;
    public $subpage;
    public $categories;
    public $a_category_selected = false;
    public $k;
    public $tags;

    public function __construct(Request $request, $page='', $subpage='')
    {
        $this->page = $page;
        $this->subpage = $subpage;
        $this->categories = Category::as_tree(); // cached tree
        $this->tags = Tag::hot_tags()->take(8); // tags are cached as well

        // Search query
        $this->k = ($request->has('k')) ? $request->get('k') : '';
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
