<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class AdminCommentController extends Controller
{
    public function index(Request $request) {
        $comments = Comment::withoutGlobalScopes()->with(['user', 'post', 'post.categories'])->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.comments.comments-index')
            ->with(compact('comments'));
    }
}
