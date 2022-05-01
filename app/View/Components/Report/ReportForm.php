<?php

namespace App\View\Components\Report;

use Illuminate\View\Component;

class ReportForm extends Component
{
    public $reported = false;
    public $reportable_id;
    public $reportable_type;
    
    public function __construct($resource)
    {
        $this->reported = (bool) $resource->reports()->where('reporter', auth()->user()->id)->count();
        $this->reportable_id = $resource->id;
        $type = strtolower(get_class($resource));
        $this->reportable_type = substr($type, strrpos($type, '\\') + 1);
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
