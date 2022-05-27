<?php

namespace App\View\Components\Admin\Category\Hierarchy\Selection;

use Illuminate\View\Component;

class SelectOneCategory extends Component
{
    public $category;
    public $inputname;
    public $inputclass;

    public function __construct($category, $inputname, $inputclass)
    {
        $this->category = $category;
        $this->inputname = $inputname;
        $this->inputclass = $inputclass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.category.hierarchy.selection.select-one-category');
    }
}
