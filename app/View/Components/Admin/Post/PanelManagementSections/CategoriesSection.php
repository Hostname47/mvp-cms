<?php

namespace App\View\Components\Admin\Post\PanelManagementSections;

use Illuminate\View\Component;
use App\Models\Category;

class CategoriesSection extends Component
{
    public $root_categories;
    
    public function __construct($post=null)
    {
        $this->root_categories = Category::whereNull('parent_category_id')->orderBy('priority', 'asc')->get();
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.post.panel-management-sections.categories-section', $data);
    }
}
