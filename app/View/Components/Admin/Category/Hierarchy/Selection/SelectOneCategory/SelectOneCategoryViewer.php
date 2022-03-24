<?php

namespace App\View\Components\Admin\Category\Hierarchy\Selection\SelectOneCategory;

use Illuminate\View\Component;
use App\Models\Category;

class SelectOneCategoryViewer extends Component
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
        return view('components.admin.category.hierarchy.selection.select-one-category.select-one-category-viewer', $data);
    }
}
