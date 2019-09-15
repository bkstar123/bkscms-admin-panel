<?php
/**
* route middleware - bkscms-disabled
*
* @objective: prevents a disabled admin account from requesting for password reset
*
* @author: tuanha
* @last-mod: 15-09-2019
*/
namespace Bkstar123\BksCMS\AdminPanel\Http\Middleware;

use Closure;
use Bkstar123\BksCMS\AdminPanel\Admin;

class CheckIfAccountDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = Admin::where('email', $request->input('email'))->first();
        if (! empty($admin) && $admin->status == 0) {
            flashing('Your account is disabled, please contact the system administrator')
                ->error()
                ->flash();
            return back();
        } 
        return $next($request);
    }
}
