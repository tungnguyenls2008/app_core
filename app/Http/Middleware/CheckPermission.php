<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;


class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('backend')->user()->is_superadmin != 1) {
            $route_name = Route::currentRouteName();
            $user_permissions = \Illuminate\Support\Facades\Auth::guard('backend')->user()->permissions;

            if ($user_permissions != null) {
                $user_permissions = json_decode($user_permissions, true);
            }

            $role_allowed = \App\Models\_Backend\Role::withoutTrashed()->whereIn('id', $user_permissions)->get()->toArray();
            $route_allowed = [];
            foreach ($role_allowed as $role) {
                array_push($route_allowed, json_decode($role['route'], true));
            }
            $route_allowed = array_flatten($route_allowed);
            if (!in_array($route_name, $route_allowed)) {

                Flash::warning('Bạn không có quyền sử dụng chức năng này.');
                return back();
            }
        }
        return $next($request);


    }
}
