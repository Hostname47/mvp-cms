<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Purifier;

class AdminCommentController extends Controller
{
    public function index(Request $request) {
        $statistics = [
            'all' => Comment::withoutGlobalScopes()->count(),
            'published' => Comment::count(),
            'draft' => Comment::withoutGlobalScopes()->where('status', 'draft')->count(),
            'trashed' => Comment::withoutGlobalScopes()->where('status', 'trashed')->count()
        ];

        $comments = Comment::withoutGlobalScopes()->with(['user', 'post', 'post.categories']);
        $tab = 'all';
        $k = '';
        if($request->has('k')) {
            $k = Purifier::clean($request->get('k'));
            $comments = $comments->where('content', 'like', "%$k%");
        } else {
            if($request->has('tab')) {
                $tab = $request->get('tab');
                switch($tab) {
                    /** In case of all we don't have to attach any condition */
                    case 'published':
                        $comments = $comments->where('status', 'published');
                        break;
                    case 'trashed':
                        $comments = $comments->where('status', 'trashed');
                        break;
                }
            }
        }

        $comments = $comments->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.comments.comments-index')
            ->with(compact('statistics'))
            ->with(compact('tab'))
            ->with(compact('k'))
            ->with(compact('comments'));
    }
}
