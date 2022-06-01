<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,BanReason,Ban};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

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

    public function ban(Request $request) {
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'ban_reason'=>'required|exists:ban_reasons,id',
            'ban_duration'=>'required_if:type,temporary|numeric|min:7|max:365',
            'type'=>['required', Rule::in(['temporary', 'permanent'])]
        ]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $this->authorize('ban_user', [User::class, $user]);

        $ban = new Ban;
        $ban->admin_id = auth()->user()->id;
        $ban->user_id = $data['user_id'];
        $ban->ban_reason = $data['ban_reason'];
        
        if($data['type'] == 'temporary') {
            $ban->ban_duration = $data['ban_duration'];
            $ban->save();
            $user->update(['status'=>'temp-banned']);
        } else {
            /**
             * For permanent ban we set duration to -1; -1 means the ban record belongs to
             * a permanent ban. (temporary ban should have 7, 14, 30 days .. etc)
             */
            $ban->ban_duration = -1;
            $ban->save();
            $user->update(['status'=>'banned']);
        }

        Session::flash('message', $user->username . ' has been banned successfully');
    }
}
