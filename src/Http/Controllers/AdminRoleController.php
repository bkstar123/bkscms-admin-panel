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

class AdminRoleController extends Controller
{
    /**
     * assign roles to the admin
     *
     * @param \Illuminate\Http\Request $request
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function assignRoles(Request $request, Admin $admin)
    {
        $assignedRoles = $request->input('to', []);
        $allRoles = Role::enabled()->get()->pluck('id')->toArray();

        // Make sure that assigned roles really exist
        $assignedRoles = array_intersect($assignedRoles, $allRoles);
        // reset array keys
        $assignedRoles = array_merge($assignedRoles, []);
        $admin->roles()->sync($assignedRoles);
        flashing('The role assignment has been successfully executed')
            ->success()
            ->flash();
        return back();
    }
}
