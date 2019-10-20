<?php
/**
 * Authorizable trait - use on the Admin model
 *
 * @author: tuanha
 * @last-mod: 20-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Traits;

trait Authorizable
{
    /**
     * @var array $assignedRoles
     */
    protected $assignedRoles = [];

    /**
     * Check whether the current admin has the given role specified by $roleID
     * $roleID = 1 (superadmins), $roleID = 2 (administrators)
     *
     * @param int $roleID
     * @return bool
     */
    public function hasRole(int $roleID)
    {
        $roles = $this->getAssignedRoles()->pluck('id')->toArray();
        return in_array($roleID, $roles, true);
    }

    /**
     * Check whether the admin has the given permission specified by the permission's alias
     *
     * @param string $permissionAlias
     * @return bool
     */
    public function hasPermission($permissionAlias)
    {
        // return trueif the current admin has either superadmins or administrators roles
        if ($this->hasRole(1) || $this->hasRole(2)) {
            return true;
        }
        // Further checks for other normal roles
        $roles = $this->getAssignedRoles();
        foreach ($roles as $role) {
            $rolePermissions = $role->permissions->pluck('alias')->toArray();
            if (in_array($permissionAlias, $rolePermissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the list of the assigned roles of the current admin
     *
     * @return array
     */
    protected function getAssignedRoles()
    {
        $this->assignedRoles = !empty($this->assignedRoles) ? $this->assignedRoles :
            $this->roles()
                 ->enabled()
                 ->with([
                    'permissions' => function ($query) {
                        $query->enabled();
                    }])->get();
        return $this->assignedRoles;
    }
}
