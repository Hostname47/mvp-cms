<?php

namespace App\View\Components\Layout\LeftPanel;

use Illuminate\View\Component;
use App\Models\Category as C;

class Category extends Component
{
    public $category;
    
    public function __construct(C $category)
    {
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.left-panel.category');
    }
}
