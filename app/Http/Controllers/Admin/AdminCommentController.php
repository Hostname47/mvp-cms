<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Comment,Post};
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

        $comments = $comments->orderBy('created_at', 'desc')->paginate(24);

        return view('admin.comments.index')
            ->with(compact('statistics'))
            ->with(compact('tab'))
            ->with(compact('k'))
            ->with(compact('comments'));
    }

    public function manage(Request $request) {
        $comment = null;
        $commenter = null;
        $post = null;
        if($request->has('comment')) {
            $comment = $request->validate(['comment'=>'exists:comments,id'])['comment'];
            $comment = Comment::withoutGlobalScopes()->find($comment);
            if($comment) {
                $commenter = User::withoutGlobalScopes()->find($comment->user_id);
                $post = Post::withoutGlobalScopes()->find($comment->post_id);
                
            }
        }
        return view('admin.comments.manage')
            ->with(compact('comment'))
            ->with(compact('commenter'))
            ->with(compact('post'));
    }

    public function trash(Request $request) {
        $this->authorize('trash', [Comment::class]);

        $comments = $this->validate($request, [
            'comments'=>'required',
            'comments.*'=>'exists:comments,id',
        ], [
            'comments.required'=>'At least one comment should be selected'
        ])['comments'];
        $comments = Comment::withoutGlobalScopes()->findMany($comments);
        
        foreach($comments as $comment) {
            $comment->update(['status'=>'trashed']);
            $comment->delete();
        }

        $message = $comments->count() . ' ' . ($comments->count() > 1 ? 'comments' : 'comment') . ' trashed successfully.';
        Session::flash('message', $message);
    }

    public function untrash(Request $request) {
        $this->authorize('untrash', [Comment::class]);

        $comments = $this->validate($request, [
            'comments'=>'required',
            'comments.*'=>'exists:comments,id',
        ], [
            'comments.required'=>'At least one comment should be selected'
        ])['comments'];
        $comments = Comment::withoutGlobalScopes()->findMany($comments);

        foreach($comments as $comment) {
            $comment->update(['status'=>'pending']);
        }

        $message = $comments->count() . ' ' . ($comments->count() > 1 ? 'comments' : 'comment') . ' untrashed and marked as pending for further review';
        Session::flash('message', $message);
    }

    public function restore(Request $request) {
        $this->authorize('restore', [Comment::class]);

        $comments = $this->validate($request, [
            'comments'=>'required',
            'comments.*'=>'exists:comments,id',
        ], [
            'comments.required'=>'At least one comment should be selected'
        ])['comments'];
        $comments = Comment::withoutGlobalScopes()->findMany($comments);

        foreach($comments as $comment) {
            $comment->update(['status'=>'published']);
            $comment->restore();
        }

        $message = $comments->count() . ' ' . ($comments->count() > 1 ? 'comments' : 'comment') . ' restored successfully';
        Session::flash('message', $message);
    }

    public function destroy(Request $request) {
        $this->authorize('destroy', [Comment::class]);

        $comments = $this->validate($request, [
            'comments'=>'required',
            'comments.*'=>'exists:comments,id',
        ], [
            'comments.required'=>'At least one comment should be selected'
        ])['comments'];
        $comments = Comment::withoutGlobalScopes()->findMany($comments);

        foreach($comments as $comment) {
            $post = Post::withoutGlobalScopes()->find($comment->post_id);
            $comment->forceDelete();
            $post->update(['comments_count'=>$post->comments()->count()]);
        }

        $message = $comments->count() . ' ' . ($comments->count() > 1 ? 'comments' : 'comment') . ' deleted permanently with success';
        Session::flash('message', $message);
    }
}
