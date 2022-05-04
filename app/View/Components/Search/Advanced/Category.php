<?php

namespace App\View\Components\Search\Advanced;

use Illuminate\View\Component;
use App\Models\Category as C;

class Category extends Component
{
    public $category;

    public function __construct(C $category)
    {
        $this->category = $category;
    }
    
    public function render()
    {
        return view('components.search.advanced.category');
    }
}
