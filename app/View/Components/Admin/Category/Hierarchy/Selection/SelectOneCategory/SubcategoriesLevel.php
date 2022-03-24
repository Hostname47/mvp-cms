<?php

namespace App\View\Components\Admin\Category\Hierarchy\Selection\SelectOneCategory;

use Illuminate\View\Component;

class SubcategoriesLevel extends Component
{
    public $categories;
    
    public function __construct($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.category.hierarchy.selection.select-one-category.subcategories-level', $data);
    }
}
