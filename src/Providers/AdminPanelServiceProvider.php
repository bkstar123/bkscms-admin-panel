<?php
/**
* @author: tuanha
* @last-mod: 02-Sept-2019
*/
namespace Bkstar123\BksCMS\AdminPanel\Providers;

use Illuminate\Support\Facades\View;
use Bkstar123\BksCMS\AdminPanel\Role;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Bkstar123\BksCMS\AdminPanel\Profile;
use Bkstar123\BksCMS\AdminPanel\Permission;
use Bkstar123\BksCMS\AdminPanel\Policies\RolePolicy;
use Bkstar123\BksCMS\AdminPanel\Policies\AdminPolicy;
use Bkstar123\BksCMS\AdminPanel\Observers\RoleObserver;
use Bkstar123\BksCMS\AdminPanel\Observers\AdminObserver;
use Bkstar123\BksCMS\AdminPanel\Console\Commands\InitAuth;
use Bkstar123\BksCMS\AdminPanel\Observers\ProfileObserver;
use Bkstar123\BksCMS\AdminPanel\Policies\PermissionPolicy;
use Bkstar123\BksCMS\AdminPanel\Http\Middleware\Authenticate;
use Bkstar123\BksCMS\AdminPanel\Observers\PermissionObserver;
use Bkstar123\BksCMS\AdminPanel\Http\Middleware\CheckIfAccountDisabled;
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
        Admin::class => AdminPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
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

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

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
            $view->with('authAdmin', auth()->user());
        });

        Admin::observe(AdminObserver::class);
        Role::observe(RoleObserver::class);
        Permission::observe(PermissionObserver::class);
        Profile::observe(ProfileObserver::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InitAuth::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/bkstar123_bkscms_adminpanel.php',
            'bkstar123_bkscms_adminpanel'
        );
        $this->app->singleton('bkscms-auth', Authenticate::class);
        $this->app->singleton('bkscms-guest', RedirectIfAuthenticated::class);
        $this->app->singleton('bkscms-disabled', CheckIfAccountDisabled::class);
    }
}
