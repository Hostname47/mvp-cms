<?php

namespace App\View\Components\Admin\Category\Viewers;

use Illuminate\View\Component;
use App\Models\Category;

class CategoryParentSelection extends Component
{
    public $categories;

    public function __construct()
    {
        $this->categories = Category::whereNull('parent_category_id')->with('subcategories')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.category.viewers.category-parent-selection', $data);
    }
}
