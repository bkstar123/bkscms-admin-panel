<?php
/**
 * RoleObserver Observer
 * Listening to the Role model events
 *
 * @author: tuanha
 * @last-mod: 13-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Observers;

use Illuminate\Support\Facades\DB;
use Bkstar123\BksCMS\AdminPanel\Role;

class RoleObserver
{
    /**
     * Listen to the Role model deleting event.
     *
     * @param  App\Modules\AdminAuth\Role $role
     * @return void
     */
    public function deleting(Role $role)
    {
        DB::transaction(function () use ($role) {
            $role->admins()->detach();
            //$role->permissions()->detach();
        });
    }
}
