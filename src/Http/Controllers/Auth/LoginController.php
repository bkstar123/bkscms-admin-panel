<?php
/**
 * @author: tuanha
 * @last-mod: 02-Sept-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('bkscms-guest:admins', ['except' => 'logout']);
    }
    
    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admins');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'user';
    }

    /**
     * Specify the page to redirect user after login
     *
     * @return string
     */
    public function redirectTo()
    {
        return config('bkstar123_bkscms_adminpanel.default_authenticated_page');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('bkstar123_bkscms_adminpanel::auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        flashing('Successfully signed out from the application')->success()->flash();
        return redirect(config('bkstar123_bkscms_adminpanel.default_unauthenticated_page'));
    }

    /**
     * Attempt to log the user into the application.
     * using either email address or username
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $authenticated = $this->tryLoginWith($request, 'email') ?: $this->tryLoginWith($request, 'username');
        if ($authenticated) {
            flashing('Welcome to the application')->success()->flash();
        } else {
            flashing('Invalid login credentials')->error()->flash();
        }
        return $authenticated;
    }

    /**
     * Attempt to login via different ways (email | username)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $loginField
     * @return boolean
     */
    protected function tryLoginWith($request, $loginField = 'email')
    {
        $credentials = $this->credentials($request);
        $credentials[$loginField] = $credentials['user'];
        $credentials['status'] = Admin::ACTIVE;
        unset($credentials['user']);
        return $this->guard()->attempt($credentials, $request->filled('remember'));
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request),
            config('bkstar123_bkscms_adminpanel.maxLoginAttempts'),
             config('bkstar123_bkscms_adminpanel.retryAfter')
        );
    }
}
