<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    public function dashboard(Request $request) {
        $statistics = \DB::select("
            SELECT 'all' as k, COUNT(*) as v FROM posts
            union all
            SELECT ANY_VALUE(status) as k, COUNT(*) AS v FROM posts GROUP BY status
        ");
        $temp = [];
        foreach($statistics as $stats) $temp[$stats->k] = $stats->v;
        $statistics = $temp;

        $tab = 'all';
        if($request->has('tab')) {
            $tab = $request->validate([
                'tab'=>[Rule::in(['all','published','awaiting-review','draft'])]
            ])['tab'];
        }

        $user = auth()->user();
        $posts = $user->posts()->withoutGlobalScopes()->with(['thumbnail','categories','tags']);
        switch($tab) {
            case 'all':
                // for all, we don't have to append any condition
                break;
            case 'published':
                $posts = $posts->where('status', 'published');
                break;
            case 'awaiting-review':
                $posts = $posts->where('status', 'awaiting-review');
                break;
            case 'draft':
                $posts = $posts->where('status', 'draft');
                break;
        }
        $posts = $posts->paginate(10);

        return view('user.author.author-dashboard')
            ->with(compact('tab'))
            ->with(compact('statistics'))
            ->with(compact('posts'));
    }
}
