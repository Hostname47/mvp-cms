<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{AuthorRequest, Post, User};
use App\View\Components\Admin\Author\Viewers\ReviewViewer;

class AdminAuthorController extends Controller
{
    public function overview(Request $request) {
        $statistics = [
            'requests'=>AuthorRequest::where('status', '<>', 1)->count(),
            'authors'=>User::where('elected_author', 1)->count(),
            'posts'=>Post::withoutGlobalScopes()->where('status', 'author-post-awaiting-review')->count(),
        ];
        return view('admin.author.overview')
            ->with(compact('statistics'));
    }

    public function requests(Request $request) {
        $requests = AuthorRequest::whereHas('user')->where('status', '<>', '1')->with(['user'])->orderBy('created_at', 'desc')->paginate(6);

        return view('admin.author.requests')
            ->with(compact('requests'));
    }

    public function author_management(Request $request) {
        $author = null;
        $authors = collect([]);

        if($request->has('author')) {
            $author = User::where('username', $request->get('author'))->first();
        }

        if(is_null($author)) {
            $authors = User::where('elected_author', 1)->paginate(10);
        }

        return view('admin.author.manage')
            ->with(compact('author'))
            ->with(compact('authors'));
    }

    public function review_viewer(Request $request) {
        $author_request = $request->validate(['request'=>'required|exists:author_requests,id'])['request'];
        $author_request = AuthorRequest::find($author_request);

        $viewer = (new ReviewViewer($author_request));
        $viewer = $viewer->render(get_object_vars($viewer))->render();
        return $viewer;
    }

    public function accept_author_request(Request $request) {
        $author_request = $request->validate(['request'=>'required|exists:author_requests,id'])['request'];
        $author_request = AuthorRequest::find($author_request);
        $user = $author_request->user;

        $this->authorize('accept', [AuthorRequest::class, $user, $author_request]);

        $user->update(['elected_author'=>1]);
        $author_request->update(['status'=>1, 'approved_by'=>auth()->user()->id]);
        $user->attach_permission('author-create-post');

        \Session::flash('message', 'Author request accepted successfully.');
    }

    public function refuse_author_request(Request $request) {
        $author_request = $request->validate(['request'=>'required|exists:author_requests,id'])['request'];
        $author_request = AuthorRequest::find($author_request);

        $this->authorize('refuse', [AuthorRequest::class]);

        $author_request->update(['status'=>-1]);

        \Session::flash('message', 'Author request refused successfully.');
    }

    public function delete_author_request(Request $request) {
        $author_request = $request->validate(['request'=>'required|exists:author_requests,id'])['request'];
        $author_request = AuthorRequest::find($author_request);

        $this->authorize('delete', [AuthorRequest::class]);

        $author_request->delete();

        \Session::flash('message', 'Author request has been deleted successfully.');
    }
}
