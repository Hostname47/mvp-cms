<?php

namespace App\View\Components\User\Activities\Sections;

use Illuminate\View\Component;

class CorrectionsSection extends Component
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
    public function render()
    {
        return view('components.user.activities.sections.corrections-section');
    }
}
