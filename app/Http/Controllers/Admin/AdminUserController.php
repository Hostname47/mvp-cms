<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function manage(Request $request) {
        $user = null;
        if($request->has('user'))
            $user = User::withoutGlobalScopes()->where('username', $request->user)->first();
        
        return view('admin.users.manage')
            ->with(compact('user'));
    }
}
