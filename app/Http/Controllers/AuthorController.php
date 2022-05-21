<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function dashboard(Request $request) {
        $user = auth()->user();
        $posts = $user->posts()->withoutGlobalScopes()->with(['thumbnail','categories','tags'])->paginate(10);
        return view('user.author.author-dashboard')
            ->with(compact('posts'));
    }
}
