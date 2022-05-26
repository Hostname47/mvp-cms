<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Comment,Post};
use Illuminate\Support\Facades\Session;
use Purifier;

class AdminCommentController extends Controller
{
    public function index(Request $request) {
        $statistics = [
            'all' => Comment::withoutGlobalScopes()->count(),
            'published' => Comment::count(),
            'pending' => Comment::withoutGlobalScopes()->where('status', 'pending')->count(),
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
                    case 'pending':
                        $comments = $comments->where('status', 'pending');
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

    public function trash(Request $request) {
        $this->authorize('trash', [Comment::class]);

        $comment_id = $request->validate(['comment_id'=>'required|exists:comments,id'])['comment_id'];
        $comment = Comment::withoutGlobalScopes()->find($comment_id);

        $comment->update(['status'=>'trashed']);
        $comment->delete();
        Session::flash('message', 'Comment trashed successfully.');
    }

    public function untrash(Request $request) {
        $this->authorize('untrash', [Comment::class]);

        $comment_id = $request->validate(['comment_id'=>'required|exists:comments,id'])['comment_id'];
        $comment = Comment::withoutGlobalScopes()->find($comment_id);

        $comment->update(['status'=>'pending']);
        Session::flash('message', 'Comment untrashed and marked as pending for further review.');
    }

    public function restore(Request $request) {
        $this->authorize('restore', [Comment::class]);

        $comment_id = $request->validate(['comment_id'=>'required|exists:comments,id'])['comment_id'];
        $comment = Comment::withoutGlobalScopes()->find($comment_id);

        $comment->update(['status'=>'published']);
        $comment->restore();

        Session::flash('message', 'Comment restored and marked as pending for review.');
    }

    public function destroy(Request $request) {
        $this->authorize('destroy', [Comment::class]);

        $comment_id = $request->validate(['comment_id'=>'required|exists:comments,id'])['comment_id'];
        $comment = Comment::withoutGlobalScopes()->find($comment_id);
        $post = Post::withoutGlobalScopes()->find($comment->post_id);

        $comment->forceDelete();
        $post->update(['comments_count'=>$post->comments()->count()]);

        Session::flash('message', 'Comment restored and marked as pending for review.');
    }
}
