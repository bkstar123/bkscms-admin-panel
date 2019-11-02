<?php
/**
 * PermissionPolicy - policy
 *
 * @author: tuanha
 * @last-mod: 02-Nov-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Policies;

use Bkstar123\BksCMS\AdminPanel\Role;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Bkstar123\BksCMS\AdminPanel\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @param string $ability
     * @return bool|null
     */
    public function before(Admin $currentAdmin, $ability)
    {
        return $currentAdmin->hasRole(Role::SUPERADMINS) ? true : null;
    }

    /**
     * Determine whether the current admin can see the permission index page.
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @return bool
     */
    public function index(Admin $currentAdmin)
    {
        return false;
    }

    /**
     * Determine whether the user can view the permission.
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @param \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return bool
     */
    public function view(Admin $currentAdmin, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the user can create permission.
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @return bool
     */
    public function create(Admin $currentAdmin)
    {
        return false;
    }

    /**
     * Determine whether the user can update the permission.
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @param \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return bool
     */
    public function update(Admin $currentAdmin, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the permission.
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @param \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return bool
     */
    public function delete(Admin $currentAdmin, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the current admin can delete multiple permissions.
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @return bool
     */
    public function massiveDelete(Admin $currentAdmin)
    {
        return false;
    }

    /**
     * Determine whether the current admin can activate the permission.
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @param \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return bool
     */
    public function activate(Admin $currentAdmin, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the current admin can deactivate the permission.
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @param \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return bool
     */
    public function deactivate(Admin $currentAdmin, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the current admin can revoke the permission.
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @param \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return bool
     */
    public function revoke(Admin $currentAdmin, Permission $permission)
    {
        return false;
    }
}
