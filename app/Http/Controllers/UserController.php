<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function profile(User $user) {
        $role = $user->high_role();
        return view('user.profile')
            ->with(compact('user'))
            ->with(compact('role'));
    }
}
