<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{AuthorRequest, Post};
use App\View\Components\Admin\Author\Viewers\ReviewViewer;

class AdminAuthorController extends Controller
{
    public function overview(Request $request) {
        $statistics = [
            'requests'=>AuthorRequest::where('status', 0)->count(),
            'posts'=>Post::withoutGlobalScopes()->where('status', 'author-post-awaiting-review')->count(),
        ];
        return view('admin.author.overview')
            ->with(compact('statistics'));
    }

    public function requests(Request $request) {
        $requests = AuthorRequest::whereHas('user')->with(['user'])->orderBy('created_at', 'desc')->paginate(4);

        return view('admin.author.requests')
            ->with(compact('requests'));
    }

    public function review_viewer(Request $request) {
        $author_request = $request->validate(['request'=>'required|exists:author_requests,id'])['request'];
        $author_request = AuthorRequest::find($author_request);

        $viewer = (new ReviewViewer($author_request));
        $viewer = $viewer->render(get_object_vars($viewer))->render();
        return $viewer;
    }
}
