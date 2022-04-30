<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Report;

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
}
