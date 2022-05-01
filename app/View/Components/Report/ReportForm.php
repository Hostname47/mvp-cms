<?php

namespace App\View\Components\Report;

use Illuminate\View\Component;

class ReportForm extends Component
{
    public $reported = false;
    
    public function __construct($resource)
    {
        $this->reported = (bool) $resource->reports()->where('reporter', auth()->user()->id)->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.report.report-form', $data);
    }
}
