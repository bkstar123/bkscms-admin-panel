<?php
/**
 * AdminPolicy - policy
 *
 * @author: tuanha
 * @last-mod: 20-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Policies;

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
        return $currentAdmin->hasRole(1) ? true : null;
    }

    /**
     * Determine if the current admin can see the admin index page.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin $currentAdmin
     * @return bool
     */
    public function index(Admin $currentAdmin)
    {
        return $currentAdmin->hasPermission('admins.index');
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
        if ($currentAdmin->id === $targetAdmin->id) {
            return true;
        } elseif (!$currentAdmin->hasPermission('admins.view')) {
            return false;
        } elseif ($currentAdmin->hasRole(2)) {
            return !$targetAdmin->hasRole(1);
        } else {
            return !$targetAdmin->hasRole(1) && !$targetAdmin->hasRole(2);
        }
    }

    /**
     * Determine if the current admin can create admins.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Admin  $currentAdmin
     * @return mixed
     */
    public function create(Admin $currentAdmin)
    {
        return $currentAdmin->hasPermission('admins.create');
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
        if ($currentAdmin->id === $targetAdmin->id) {
            return true;
        } elseif (!$currentAdmin->hasPermission('admins.update')) {
            return false;
        } elseif ($currentAdmin->hasRole(2)) {
            return !$targetAdmin->hasRole(1);
        } else {
            return !$targetAdmin->hasRole(1) && !$targetAdmin->hasRole(2);
        }
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
        if ($currentAdmin->id === $targetAdmin->id) {
            return true;
        } elseif (!$currentAdmin->hasPermission('admins.delete')) {
            return false;
        } elseif ($currentAdmin->hasRole(2)) {
            return !$targetAdmin->hasRole(1);
        } else {
            return !$targetAdmin->hasRole(1) && !$targetAdmin->hasRole(2);
        }
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
        if ($currentAdmin->id === $targetAdmin->id) {
            return true;
        } elseif (!$currentAdmin->hasPermission('admins.activate')) {
            return false;
        } elseif ($currentAdmin->hasRole(2)) {
            return !$targetAdmin->hasRole(1);
        } else {
            return !$targetAdmin->hasRole(1) && !$targetAdmin->hasRole(2);
        }
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
        if ($currentAdmin->id === $targetAdmin->id) {
            return true;
        } elseif (!$currentAdmin->hasPermission('admins.deactivate')) {
            return false;
        } elseif ($currentAdmin->hasRole(2)) {
            return !$targetAdmin->hasRole(1);
        } else {
            return !$targetAdmin->hasRole(1) && !$targetAdmin->hasRole(2);
        }
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
        if ($currentAdmin->id === $targetAdmin->id) {
            return true;
        } elseif (!$currentAdmin->hasPermission('admins.changePassword')) {
            return false;
        } elseif ($currentAdmin->hasRole(2)) {
            return !$targetAdmin->hasRole(1);
        } else {
            return !$targetAdmin->hasRole(1) && !$targetAdmin->hasRole(2);
        }
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
        return $currentAdmin->hasRole(2) && !$targetAdmin->hasRole(1);
    }
}
