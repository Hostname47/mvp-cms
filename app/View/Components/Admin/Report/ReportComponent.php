<?php

namespace App\View\Components\Admin\Report;

use Illuminate\View\Component;

class ReportComponent extends Component
{
    public $report;
    public $resource;
    
    public function __construct($report)
    {
        $this->report = $report;
        $this->resource = $report->resource;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.report.report-component', $data);
    }
}
