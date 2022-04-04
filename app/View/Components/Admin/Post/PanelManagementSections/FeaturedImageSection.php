<?php

namespace App\View\Components\Admin\Post\PanelManagementSections;

use Illuminate\View\Component;

class FeaturedImageSection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.post.panel-management-sections.featured-image-section', $data);
    }
}
