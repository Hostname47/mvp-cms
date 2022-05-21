<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function dashboard(Request $request) {
        $user = auth()->user();
        $statistics = [
            'all' => $user->posts()->withoutGlobalScopes()->count(),
            'published' => $user->posts()->withoutGlobalScopes()->where('status', 'published')->count(),
            'awaiting-review' => $user->posts()->withoutGlobalScopes()->where('status', 'awaiting-review')->count(),
            'draft' => $user->posts()->withoutGlobalScopes()->where('status', 'draft')->count(),
            'deleted' => $user->posts()->withoutGlobalScopes()->whereNotNull('deleted_at')->count(),
        ];

        $tab = 'all';
        if($request->has('tab')) {
            $tab = $request->validate([
                'tab'=>[Rule::in(['all','published','awaiting-review','draft','deleted'])]
            ])['tab'];
        }

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
            case 'deleted':
                $posts = $posts->whereNotNull('deleted_at');
                break;
        }
        $posts = $posts->paginate(10);

        return view('user.author.author-dashboard')
            ->with(compact('tab'))
            ->with(compact('statistics'))
            ->with(compact('posts'));
    }
}
