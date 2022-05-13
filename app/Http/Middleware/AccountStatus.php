<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
            $status = $user->status;
            switch($status) {
                case 'active':
                    return $next($request);
                case 'deactivated':
                    return redirect()->route('user.account.activate');
                case 'temp-banned':
                    /** React to temporary ban */
                    break;
                case 'banned':
                    /** React to ban */
                    break;
                case 'deleted':
                    /** React to ban */
                    break;
            }
        }

        return $next($request);
    }
}
