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
        $ban = null;
        $banned = false;
        $banreasons = collect([]);
        $tab = 'posts';
        $resources = collect([]);
        if($request->has('user')) {
            $user = User::withoutGlobalScopes()->where('username', $request->user)->first();
            if($user) {
                $highrole = ($hr = $user->high_role(true)) ? $hr->title : $highrole;
                $banned = $user->is_banned();
                $ban = $user->bans()->orderBy('created_at', 'desc')->first();
                $banreasons = BanReason::all();
                
                if($request->has('tab')) {
                    $tab = $request->validate(['tab'=>[Rule::in(['posts','comments','bans'])]])['tab'];
                }

                switch($tab) {
                    case 'comments':
                        $resources = $user->comments()->with(['post'])->withoutGlobalScopes()->orderBy('created_at', 'desc')->paginate(12);
                        break;
                    default:
                        $resources = $user->posts()->with(['categories'])->withoutGlobalScopes()->orderBy('created_at', 'desc')->paginate(12);
                        break;
                }
            }
        }
        
        return view('admin.users.manage')
            ->with(compact('user'))
            ->with(compact('banned'))
            ->with(compact('ban'))
            ->with(compact('banreasons'))
            ->with(compact('highrole'))
            ->with(compact('tab'))
            ->with(compact('resources'));
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

    public function unban(Request $request) {
        $this->authorize('unban_user', [User::class]);
        $data = $request->validate(['user_id'=>'required|exists:users,id']);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        // Delete all bans records (soft delete)
        $user->bans()->delete();
        // Then we change account status to active
        $user->update(['status'=>'active']);
        Session::flash('message', $user->username . '\'s account has been unbaned and restored successfully');
    }

    public function clear_expired_ban(Request $request) {
        $user_id = $request->validate(['user_id'=>'required|exists:users,id'])['user_id'];
        $user = User::withoutGlobalScopes()->find($user_id);
        $this->authorize('unban_user', [User::class]);
        
        $user->bans()->where('ban_duration', '<>', -1)->orderBy('created_at', 'desc')->first()->delete();
        $user->update(['status'=>'active']);

        Session::flash('message', 'Expired ban has been cleared successfully along with setting the account status to active');
    }

    public function delete(Request $request) {
        $id = $request->validate(['user_id'=>'required|exists:users,id'])['user_id'];
        $user = User::withoutGlobalScopes()->find($id);
        $this->authorize('delete', [User::class, $user]);

        $user->delete();
        $data = $user->toArray();
        $user->forceDelete(); // Look at boot method in User model to check cleanups
        /**
         * Here we force delete the user account to run cascading delete to clean all related
         * relationships. After that we recreate the user with the same data by mark its account
         * as deleted (soft delete it and give it deleted status).
         */
        $data['status'] = 'deleted';
        $new_account = User::create($data);
        
        Session::flash('message', 'User account has been deleted successfully. A record with username and email will be preserved to prevent future impersonation.');
    }
}
