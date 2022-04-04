<?php

namespace App\View\Components\Admin\Post;

use Illuminate\View\Component;
use App\Models\Category;

class PostManagementPanel extends Component
{
    public $root_categories;

    public function __construct()
    {
        $this->root_categories = Category::whereNull('parent_category_id')->orderBy('priority', 'asc')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.post.post-management-panel', $data);
    }
}
