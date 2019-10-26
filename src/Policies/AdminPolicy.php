<?php
/**
 * AdminPolicy - policy
 *
 * @author: tuanha
 * @last-mod: 26-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Policies;

use Bkstar123\BksCMS\AdminPanel\Role;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
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
     * Determine if the current admin can see the admin index page.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @return bool
     */
    public function index(Admin $currentAdmin)
    {
        return $this->commonRule($currentAdmin, null, 'admins.index');
    }
    
    /**
     * Determine if the current admin can view another admin profile.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $targetAdmin
     * @return mixed
     */
    public function view(Admin $currentAdmin, Admin $targetAdmin)
    {
        return $this->commonRule($currentAdmin, $targetAdmin, 'admins.view');
    }

    /**
     * Determine if the current admin can create admins.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @return mixed
     */
    public function create(Admin $currentAdmin)
    {
        return $this->commonRule($currentAdmin, null, 'admins.create');
    }

    /**
     * Determine if the current admin can update another admin profile.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $targetAdmin
     * @return mixed
     */
    public function update(Admin $currentAdmin, Admin $targetAdmin)
    {
        return $this->commonRule($currentAdmin, $targetAdmin, 'admins.update');
    }

    /**
     * Determine if the current admin can delete another admin.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $targetAdmin
     * @return mixed
     */
    public function delete(Admin $currentAdmin, Admin $targetAdmin)
    {
        return $this->commonRule($currentAdmin, $targetAdmin, 'admins.delete');
    }

    /**
     * Determine if the current admin can delete multiple target admins.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @return bool
     */
    public function massiveDelete(Admin $currentAdmin)
    {
        return false;
    }

    /**
     * Determine if the current admin can activate another admin.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $targetAdmin
     * @return bool
     */
    public function activate(Admin $currentAdmin, Admin $targetAdmin)
    {
        return $this->commonRule($currentAdmin, $targetAdmin, 'admins.activate');
    }

    /**
     * Determine if the current admin can de-activate another admin.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $targetAdmin
     * @return bool
     */
    public function deactivate(Admin $currentAdmin, Admin $targetAdmin)
    {
        return $this->commonRule($currentAdmin, $targetAdmin, 'admins.deactivate');
    }

    /**
     * Determine if the current admin can change the password for another admin.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $targetAdmin
     * @return bool
     */
    public function changePassword(Admin $currentAdmin, Admin $targetAdmin)
    {
        return $this->commonRule($currentAdmin, $targetAdmin, 'admins.changePassword');
    }

    /**
     * Determine if the current admin can assign roles to the target admin.
     *
     * @param  App\Modules\AdminAuth\Admin  $currentAdmin
     * @param  App\Modules\AdminAuth\Admin   $targetAdmin
     * @return bool
     */
    public function assignRoles(Admin $currentAdmin, Admin $targetAdmin)
    {
        return $currentAdmin->hasRole(Role::ADMINISTRATORS) && !$targetAdmin->hasRole(Role::SUPERADMINS);
    }

    /**
     * A common business rule for policy definition
     * @param  App\Modules\AdminAuth\Admin  $currentAdmin
     * @param  App\Modules\AdminAuth\Admin  $targetAdmin
     * @param  string  $permissionAlias
     * @return bool
     */
    protected function commonRule($currentAdmin, $targetAdmin = null, $permissionAlias)
    {
        if (is_null($targetAdmin)) {
            return $currentAdmin->hasPermission($permissionAlias);
        } elseif ($currentAdmin->id === $targetAdmin->id) {
            return true;
        } elseif (!$currentAdmin->hasPermission($permissionAlias)) {
            return false;
        } elseif ($currentAdmin->hasRole(Role::ADMINISTRATORS)) {
            return !$targetAdmin->hasRole(Role::SUPERADMINS);
        } else {
            return !$targetAdmin->hasRole(Role::SUPERADMINS) && !$targetAdmin->hasRole(Role::ADMINISTRATORS);
        }
    }
}
