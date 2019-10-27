<?php
/**
 * RolePolicy - policy
 *
 * @author: tuanha
 * @last-mod: 27-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Policies;

use Bkstar123\BksCMS\AdminPanel\Role;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @param string $ability
     * @return bool|null
     */
    public function before(Admin $currentAdmin, $ability)
    {
        return null;
    }

    /**
     * Determine if the current admin can see the role index page.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @return bool
     */
    public function index(Admin $currentAdmin)
    {
        return $currentAdmin->hasRole(Role::ADMINISTRATORS) || $currentAdmin->hasRole(Role::SUPERADMINS);
    }
    
    /**
     * Determine if the current admin can view a role.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Role  $role
     * @return mixed
     */
    public function view(Admin $currentAdmin, Role $role)
    {
        return $currentAdmin->hasRole(Role::ADMINISTRATORS) || $currentAdmin->hasRole(Role::SUPERADMINS);
    }

    /**
     * Determine if the current admin can create a new role.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @return mixed
     */
    public function create(Admin $currentAdmin)
    {
        return $currentAdmin->hasRole(Role::ADMINISTRATORS) || $currentAdmin->hasRole(Role::SUPERADMINS);
    }

    /**
     * Determine if the current admin can update another admin profile.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Role  $role
     * @return mixed
     */
    public function update(Admin $currentAdmin, Role $role)
    {
        return $this->commonRule($currentAdmin, $role);
    }

    /**
     * Determine if the current admin can delete a role.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Role  $role
     * @return mixed
     */
    public function delete(Admin $currentAdmin, Role $role)
    {
        return $this->commonRule($currentAdmin, $role);
    }

    /**
     * Determine if the current admin can delete multiple roles.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @return bool
     */
    public function massiveDelete(Admin $currentAdmin)
    {
        return $currentAdmin->hasRole(Role::SUPERADMINS);
    }

    /**
     * Determine if the current admin can activate a role.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Role  $role
     * @return bool
     */
    public function activate(Admin $currentAdmin, Role $role)
    {
        return $this->commonRule($currentAdmin, $role);
    }

    /**
     * Determine if the current admin can de-activate a role.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Role  $role
     * @return bool
     */
    public function deactivate(Admin $currentAdmin, Role $role)
    {
        return $this->commonRule($currentAdmin, $role);
    }

    /**
     * Determine whether the current admin can revoke a role.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Role $role
     * @return bool
     */
    public function revoke(Admin $currentAdmin, Role $role)
    {
        return $this->commonRule($currentAdmin, $role);
    }

    /**
     * Determine whether the current admin can attach permissions to a role.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Role  $role
     * @return bool
     */
    public function attachPermissions(Admin $currentAdmin, Role $role)
    {
        return $this->commonRule($currentAdmin, $role);
    }

    /**
     * A common business rule for role policies
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Role  $role
     * @return bool
     */
    protected function commonRule($currentAdmin, $role)
    {
        return !in_array($role->id, [Role::SUPERADMINS, Role::ADMINISTRATORS]) && 
            ($currentAdmin->hasRole(Role::ADMINISTRATORS) || $currentAdmin->hasRole(Role::SUPERADMINS));
    }
}
