<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($user = auth()->user()) {
            switch($user->status) {
                case 'active':
                    return $next($request);
                case 'deactivated':
                    return redirect()->route('user.account.activate');
                case 'temp-banned':
                    /**
                     * We check if the duration of temporary ban is experid; If so we have to delete ban 
                     * record (soft delete it), and set user account status to live
                     */
                    $ban = $user->bans()->orderBy('created_at', 'desc')->where('ban_duration', '<>', -1)->first();
                    if(is_null($ban) || $ban->is_expired) {
                        $user->update(['status'=>'active']);
                        $ban->delete();
                    }
                    break;
                case 'deleted':
                case 'banned':
                    /**
                     * When the user account is deleted or banned permanently, we need to logout the user first,
                     * then we prevent the user from login in Authentication phase through AccountStatus
                     * middleware by displaying a flash message about the ban or deletion
                     */
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    break;
            }
        }

        return $next($request);
    }
}
