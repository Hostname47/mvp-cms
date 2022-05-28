<?php

namespace App\View\Components\Admin\Category\Hierarchy\Selection;

use Illuminate\View\Component;

class SelectByClickCategory extends Component
{
    public $category;
    
    public function __construct($category)
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
        return view('components.admin.category.hierarchy.selection.select-by-click-category');
    }
}
