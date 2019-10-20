<?php
/**
 * PermissionRoleController
 *
 * @author: tuanha
 * @last-mod: 20-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bkstar123\BksCMS\AdminPanel\Role;
use Bkstar123\BksCMS\AdminPanel\Permission;

class PermissionRoleController extends Controller
{
    /**
     * Assign permissions to the role
     *
     * @param \Illuminate\Http\Request $request
     * @param \Bkstar123\BksCMS\AdminPanel\Role $role
     * @return \Illuminate\Http\Response
     */
    public function assignPermissions(Request $request, Role $role)
    {
        $assignedPermissions = $request->input('to', []);
        $allPermissions = Permission::enabled()->get()->pluck('id')->toArray();

        // Make sure that assigned permissions really exist
        $assignedPermissions = array_intersect($assignedPermissions, $allPermissions);
        // reset array keys
        $assignedPermissions = array_merge($assignedPermissions, []);
        try {
            $role->permissions()->sync($assignedPermissions);
            flashing('The permission assignment has been successfully executed')
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
