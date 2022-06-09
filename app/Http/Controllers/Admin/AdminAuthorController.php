<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{AuthorRequest, Post};

class AdminAuthorController extends Controller
{
    public function overview(Request $request) {
        // $requests = AuthorRequest::with(['user'])->orderBy('created_at', 'desc')->paginate(16);
        $statistics = [
            'requests'=>AuthorRequest::where('status', 0)->count(),
            'posts'=>Post::withoutGlobalScopes()->where('status', 'author-post-awaiting-review')->count(),
        ];
        return view('admin.author.overview')
            ->with(compact('statistics'));
    }
}
