<?php
/**
 * RoleController
 *
 * @author: tuanha
 * @last-mod: 14-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use Bkstar123\BksCMS\AdminPanel\Role;
use Bkstar123\BksCMS\AdminPanel\Http\Requests\StoreRole;
use Bkstar123\BksCMS\AdminPanel\Http\Requests\UpdateRole;
use Bkstar123\BksCMS\AdminPanel\Traits\AuthorizationShield;

class RoleController extends Controller
{
    use AuthorizationShield;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->capabilityCheck('index', Role::class);
        $searchText = request()->input('search');
        try {
            $roles = Role::search($searchText)
                    ->simplePaginate(config('bkstar123_bkscms_adminpanel.pageSize'))
                    ->appends([
                        'search' => $searchText
                    ]);
        } catch (Exception $e) {
            $roles = [];
        }
        return view('bkstar123_bkscms_adminpanel::roles.index', compact('roles'));
    }

    /**
     * Show create form
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->capabilityCheck('create', Role::class);
        return view('bkstar123_bkscms_adminpanel::roles.create');
    }

    /**
     * Store a resource
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Http\Requests\StoreRole $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {
        $this->capabilityCheck('create', Role::class);
        try {
            $role = Role::create($request->all());
            flashing("New role $role->role has been created")
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back();
    }

    /**
     * Show a resource
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->capabilityCheck('view', $role);
        return view('bkstar123_bkscms_adminpanel::roles.show', compact('role'));
    }

    /**
     * Update a resource
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Http\Requests\UpdateRole $request
     * @param \Bkstar123\BksCMS\AdminPanel\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRole $request, Role $role)
    {
        $this->capabilityCheck('update', $role);
        try {
            $role->update($request->all());
            flashing("The role $role->role's metadata has been successfully updated")
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back();
    }

    /**
     * Destroy a resource
     *
     * @param \Blstar123\BksCMS\AdminPanel\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->capabilityCheck('delete', $role);
        try {
            $role->delete();
            flashing("The role $role->role has been successfully removed")
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back()->getTargetUrl() != route('roles.show', [
            'role' => $role->{$role->getRouteKeyName()}
        ]) ? back() : redirect()->route('roles.index');
    }
    
    /**
     * Destroy multiple resources
     *
     * @return \Illuminate\Http\Response
     */
    public function massiveDestroy()
    {
        $this->capabilityCheck('massiveDelete', Role::class);
        $Ids = explode(',', request()->input('Ids'));
        $Ids = array_diff($Ids, [Role::SUPERADMINS, ROLE::ADMINISTRATORS]);
        $Ids = array_merge($Ids, []);
        try {
            Role::destroy($Ids);
            flashing('All selected resources have been removed')
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back();
    }

    /**
     * Disabling the given role
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Role $role
     * @return \Illuminate\Http\Response
     */
    public function offStatus(Role $role)
    {
        $this->capabilityCheck('deactivate', $role);
        $role->status = Role::DISABLED;
        try {
            $role->save();
            flashing("The role $role->role has been successfully disabled")
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back();
    }

    /**
     * Enabling the given role
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Role $role
     * @return \Illuminate\Http\Response
     */
    public function onStatus(Role $role)
    {
        $this->capabilityCheck('activate', $role);
        $role->status = Role::ENABLED;
        try {
            $role->save();
            flashing("The account $role->role has been successfully enabled")
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
