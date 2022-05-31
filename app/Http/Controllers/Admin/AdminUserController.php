<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function manage(Request $request) {
        $user = null;
        if($request->has('user'))
            $post = User::withoutGlobalScopes()->where('username', $request->user)->first();
        
        return view('admin.users.manage')
            ->with(compact('user'));
    }
}
