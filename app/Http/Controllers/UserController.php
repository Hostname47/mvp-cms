<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function profile(User $user) {
        $roles = $user->roles;
        $hasrole = $roles->count() > 0;
        $hrole = $roles->sortBy('priority')->first();
        $posts = $user->posts()->with(['author','author.roles','categories','tags'])->orderBy('published_at', 'desc')->paginate(10);

        return view('user.profile')
            ->with(compact('user'))
            ->with(compact('hasrole'))
            ->with(compact('hrole'))
            ->with(compact('posts'))
            ->with(compact('roles'));
    }

    public function settings() {
        $user = auth()->user();
        return view('settings.profile-settings')
            ->with(compact('user'));
    }
}
