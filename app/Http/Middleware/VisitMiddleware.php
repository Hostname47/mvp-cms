<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit;

class VisitMiddleware
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
        session(['current-url'=>request()->url()]); // Used to redirect user to previous page after login
        
        $authuser = auth()->user();
        $visit = null;
        if($authuser)
            $visit = $authuser->visits()->where('created_at', '>', today())->where('url', url()->current())->first();
        else
            $visit = Visit::where('visitor_ip', $request->ip())
                ->where('created_at', '>', today())
                ->where('url', url()->current())->first();

        if($visit) {
            $visit->increment('hits');
        } else {
            $visit = new Visit();
            $visit->visitor_ip = $request->ip();
            $visit->visitor_id = ($authuser) ? $authuser->id : null;
            $visit->url = url()->current();
            $visit->save();
        }

        return $next($request);
    }
}
