<?php

namespace App\View\Components\Category;

use Illuminate\View\Component;
use App\Models\Category;

class CategorySelect extends Component
{
    public $category;
    
    public function __construct(Category $category)
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
        return view('components.category.category-select');
    }
}
