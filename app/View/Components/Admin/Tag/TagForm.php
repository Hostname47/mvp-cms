<?php

namespace App\View\Components\Admin\Tag;

use Illuminate\View\Component;

class TagForm extends Component
{
    public $operation;
    
    public function __construct($operation)
    {
        $this->operation = $operation;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.tag.tag-form');
    }
}
