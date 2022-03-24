<?php

namespace App\View\Components\Admin\Category\Hierarchy\ClickSelection;

use Illuminate\View\Component;

class SubcategoriesLevel extends Component
{
    public $categories;
    public $route = '';
    
    public function __construct($categories, $route=false)
    {
        $this->categories = $categories;
        if($route) $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.category.hierarchy.click-selection.subcategories-level', $data);
    }
}
