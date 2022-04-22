<?php

namespace App\View\Components\Layout\LeftPanel;

use Illuminate\View\Component;
use App\Models\{Category};

class LeftPanel extends Component
{
    public $categories;

    public function __construct()
    {
        $this->categories = Category::tree()->get()->toTree();
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
