<?php
/**
* route middleware - adminpanel-guest
* Prevents an authenticated admin user from trying to access Auth controllers
*
* @author: tuanha
* @last-mod: 02-Sept-2019
*/
namespace Bkstar123\BksCMS\AdminPanel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = Auth::guard($guard);
        if ($auth->check() && $auth->user()->status === 1) {
            return redirect(config('bkstar123_bkscms_adminpanel.default_authenticated_page'));
        }

        return $next($request);
    }
}
