<?php

namespace App\View\Components\Admin\Category;

use Illuminate\View\Component;

class FormInputs extends Component
{
    public $category;
    public $action;

    public function __construct($category=false, $action)
    {
        $this->category = $category;
        $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.category.form-inputs');
    }
}
