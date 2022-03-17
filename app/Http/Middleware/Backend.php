<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Backend extends Middleware
{
//    /**
//     * Handle an incoming request.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Closure  $next
//     * @return mixed
//     */
//    public function handle(Request $request, Closure $next)
//    {
//        return $next($request);
//    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('backend-login');
        }
    }
//    public function handle($request, Closure $next, $guard = null)
//    {
//        if (Auth::guard('backend')->guest()) {
//            if ($request->ajax() || $request->wantsJson()) {
//                return response('Unauthorized.', 401);
//            } else {
//                return redirect(route('backend-login-view'));
//            }
//        }
//
//        return $next($request);
//
//    }

}
