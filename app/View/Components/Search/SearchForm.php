<?php

namespace App\View\Components\Search;

use Illuminate\View\Component;

class SearchForm extends Component
{
    public $route;
    public $placeholder;
    public $hasfilter;
    public $type;
    public $k;

    public function __construct($route, $placeholder, $hasfilter, $type, $k="")
    {
        $this->route = route($route);
        $this->placeholder = $placeholder;
        $this->hasfilter = $hasfilter;
        $this->type = $type;
        $this->k = $k;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.search.search-form', $data);
    }
}
