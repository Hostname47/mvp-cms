<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function manage(Request $request) {
        $user = null;
        $highrole = 'Normal User';
        $banreasons = collect([]);
        if($request->has('user')) {
            $user = User::withoutGlobalScopes()->where('username', $request->user)->first();
            if($user) {
                $highrole = ($hr = $user->high_role(true)) ? $hr->title : $highrole;

            }
        }
        
        return view('admin.users.manage')
            ->with(compact('user'))
            ->with(compact('banreasons'))
            ->with(compact('highrole'));
    }
}
