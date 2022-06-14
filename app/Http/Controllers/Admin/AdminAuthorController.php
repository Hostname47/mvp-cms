<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{AuthorRequest, Post, User, Role};
use App\View\Components\Admin\Author\Viewers\ReviewViewer;
use App\Helpers\Search;
use Purifier;

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
        $tab = 'all';
        $k = null;
        $posts = collect([]);
        $statistics = [];

        if($request->has('author')) {
            $author = User::where('username', $request->get('author'))->first();
        }

        if(is_null($author)) {
            if($request->has('k')) {
                $k = Purifier::clean($request->get('k'));
                $authors = Search::search(User::with('author_requests')->where('elected_author', 1), $k, ['username','firstname','lastname'], ['like','like','like'])->paginate(10);
            } else {
                $authors = User::with('author_requests')->where('elected_author', 1)->paginate(10);
            }
        } else {
            $statistics = [
                'all' => $author->posts()->withoutGlobalScopes()->count(),
                'published' => $author->posts()->withoutGlobalScopes()->where('status', 'published')->count(),
                'awaiting-review' => $author->posts()->withoutGlobalScopes()->where('status', 'awaiting-review')->count(),
                'draft' => $author->posts()->withoutGlobalScopes()->where('status', 'draft')->count(),
                'deleted' => $author->posts()->withoutGlobalScopes()->whereNotNull('deleted_at')->count(),
            ];

            if($request->has('tab')) {
                $tab = $request->validate(['tab'=>['sometimes', Rule::in(['all','published','awaiting-review','draft', 'deleted'])]])['tab'];
            }
            
            $posts = $author->posts()->withoutGlobalScopes()->with(['thumbnail','categories','tags']);
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
        }

        return view('admin.author.manage')
            ->with(compact('author'))
            ->with(compact('authors'))
            ->with(compact('tab'))
            ->with(compact('statistics'))
            ->with(compact('posts'))
            ->with(compact('k'));
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
        /**
         * the accepted user will take contributed author role which allows him
         * to create posts through create post permission
         */
        $user->grant_role('contributor-author');

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

    public function revoke(Request $request) {
        $this->authorize('revoke', [Role::class]);
        $data = $request->validate([
            'user'=>'required|exists:users,id',
            'author_resources_action'=>['sometimes', Rule::in(['delete', 'keep'])]
        ]);

        $author = User::withoutGlobalScopes()->find($data['user']);
        $author->update(['elected_author'=>0]);
        $author->author_requests()->delete();
        /**
         * the accepted user will take contributed author role which allows him
         * to create posts through create post permission
         */
        $author->revoke_role('contributor-author');
        /**
         * Here we need to decide whether to keep or delete author resources after
         * revoking contributor author role from him
         */
        if(isset($data['author_resources_action'])) {
            switch($data['author_resources_action']) {
                case 'keep':
                    break;
                case 'delete':
                    $author->posts()->withoutGlobalScopes()->forceDelete();
                    break;
            }
        }

        \Session::flash('message', 'Contributor author role has been revoked from <strong>' . $author->username . '</strong> successfully.');
        return route('admin.author.management');
    }
}
