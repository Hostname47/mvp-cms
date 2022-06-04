<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Report,Comment};
use App\View\Components\Report\ReportForm;

class ReportController extends Controller
{
    public function report(Request $request) {
        $data = $request->validate([
            'reportable_id'=>'required|numeric',
            'reportable_type'=>['required', Rule::in(['post','comment'])],
            'body'=>'required_if:type,moderator-intervention|max:500|min:10',
            'type'=>['required', Rule::in(['spam', 'rude-or-abusive', 'low-quality', 'moderator-intervention'])]
        ]);

        // Set reporter (current user)
        $data['reporter'] = auth()->user()->id;

        // Set reportable type model path
        switch($data['reportable_type']) {
            case 'post':
                $data['reportable_type'] = 'App\Models\Post';
                break;
            case 'comment':
                $data['reportable_type'] = 'App\Models\Comment';
                break;
        }
        
        // Handle authorization first
        $this->authorize('report', [Report::class, $data]);

        Report::create($data);
    }

    public function viewer(Request $request) {
        $data = $request->validate([
            'reportable_id'=>'required|numeric',
            'reportable_type'=>['required', Rule::in(['post','comment'])],
        ]);

        $reportable = null;
        switch($data['reportable_type']) {
            case 'comment':
                $reportable = Comment::find($data['reportable_id']);
                break;
        }

        // Handle authorization first
        $this->authorize('viewer', [Report::class, $reportable]);

        $report_form = (new ReportForm($reportable));
        $report_form = $report_form->render(get_object_vars($report_form))->render();
        return $report_form;
    }

    /**
     * Admin section
     */
    public function manage(Request $request) {
        $reports = Report::with(['report_user'])->paginate(12);

        return view('admin.reports.manage')
            ->with(compact('reports'));
    }
}
