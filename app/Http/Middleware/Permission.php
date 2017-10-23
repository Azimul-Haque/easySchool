<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Permission;
use Session;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
        {
          if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
              return response('Unauthorized.', 401);
            } else {
              return redirect()->guest('login');
            }
          } else if (Permission::where('name', 'role-edit')) {
            return redirect()->to('/')->withError('Permission Denied');
          }

          return $next($request);
        }    
}
