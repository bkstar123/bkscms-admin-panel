<?php
/**
 * AdminRoleController
 *
 * @author: tuanha
 * @last-mod: 06-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bkstar123\BksCMS\AdminPanel\Role;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Bkstar123\BksCMS\AdminPanel\Traits\AuthorizationShield;

class AdminRoleController extends Controller
{
    use AuthorizationShield;

    /**
     * Assign roles to the admin
     *
     * @param \Illuminate\Http\Request $request
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function assignRoles(Request $request, Admin $admin)
    {
        $this->capabilityCheck('assignRoles', $admin);
        $assignedRoles = $request->input('to', []);
        $allRoles = Role::enabled()->get()->pluck('id')->toArray();
        $currentAdmin = auth()->guard('admins')->user();
        if ($currentAdmin->hasRole(2)) {
            $assignedRoles = array_diff($assignedRoles, [1]);
        } elseif (!$currentAdmin->hasRole(2) && !$currentAdmin->hasRole(1)) {
            $assignedRoles = array_diff($assignedRoles, [1, 2]);
        }
        // Make sure that assigned roles really exist
        $assignedRoles = array_intersect($assignedRoles, $allRoles);
        // reset array keys
        $assignedRoles = array_merge($assignedRoles, []);
        try {
            $admin->roles()->sync($assignedRoles);
            flashing('The role assignment has been successfully executed')
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back();
    }
}
