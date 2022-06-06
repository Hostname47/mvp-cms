<?php

namespace App\View\Components\Admin\Faqs;

use Illuminate\View\Component;

class Faq extends Component
{
    public $faq;
    
    public function __construct($faq)
    {
        $this->faq = $faq;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.faqs.faq');
    }
}
