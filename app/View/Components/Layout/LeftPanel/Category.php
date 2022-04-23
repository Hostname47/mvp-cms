<?php

namespace App\View\Components\Layout\LeftPanel;

use Illuminate\View\Component;
use Illuminate\Http\Request;
use App\Models\Category as C;

class Category extends Component
{
    public $category;
    public $selected; // If a category is selected
    
    public function __construct(Request $request, C $category)
    {
        $this->category = $category;
        $this->selected = $request->has('category') && $request->get('category') == $category->slug;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.left-panel.category');
    }
}
