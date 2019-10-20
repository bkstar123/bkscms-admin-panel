<?php
/**
 * PermissionObserver Observer
 * Listening to the Permission model events
 *
 * @author: tuanha
 * @last-mod: 20-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Observers;

use Bkstar123\BksCMS\AdminPanel\Permission;

class PermissionObserver
{
    /**
     * Listen to the Permission model deleting event.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return void
     */
    public function deleting(Permission $permission)
    {
        $permission->roles()->detach();
    }
}
