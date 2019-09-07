<?php
/**
* @author: tuanha
* @last-mod: 02-Sept-2019
*/
namespace Bkstar123\BksCMS\AdminPanel\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Bkstar123\BksCMS\AdminPanel\Http\Middleware\Authenticate;
use Bkstar123\BksCMS\AdminPanel\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AdminPanelServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'bkstar123_bkscms_adminpanel');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/bkstar123_bkscms_adminpanel'),
        ], 'bkstar123_bkscms_adminpanel.views');

        $this->publishes([
            __DIR__.'/../config/bkstar123_bkscms_adminpanel.php' => config_path('bkstar123_bkscms_adminpanel.php'),
        ], 'bkstar123_bkscms_adminpanel.config');

        /**
         * Binding $authAdmin to all views
         */
        View::composer('*', function ($view) {
            $view->with('authAdmin', Auth::guard('admins')->user());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bkstar123_bkscms_adminpanel.php', 'bkstar123_bkscms_adminpanel');

        $this->app->singleton('bkscms-guest', RedirectIfAuthenticated::class);
        $this->app->singleton('bkscms-auth', Authenticate::class);
    }
}
