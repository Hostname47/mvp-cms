<?php

namespace App\View\Components\Admin\Category\Hierarchy\ClickSelection;

use Illuminate\View\Component;
use App\Models\Category;

class SelectViewer extends Component
{
    public $categories;
    
    public function __construct()
    {
        $this->categories = Category::whereNull('parent_category_id')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.category.hierarchy.click-selection.select-viewer', $data);
    }
}
