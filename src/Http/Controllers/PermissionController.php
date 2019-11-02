<?php
/**
 * PermissionController
 *
 * @author: tuanha
 * @last-mod: 20-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use Bkstar123\BksCMS\AdminPanel\Permission;
use Bkstar123\BksCMS\AdminPanel\Traits\AuthorizationShield;
use Bkstar123\BksCMS\AdminPanel\Http\Requests\StorePermission;
use Bkstar123\BksCMS\AdminPanel\Http\Requests\UpdatePermission;

class PermissionController extends Controller
{
    use AuthorizationShield;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->capabilityCheck('index', Permission::class);
        $searchText = request()->input('search');
        try {
            $permissions = Permission::search($searchText)
                    ->simplePaginate(config('bkstar123_bkscms_adminpanel.pageSize'))
                    ->appends([
                        'search' => $searchText
                    ]);
        } catch (Exception $e) {
            $permissions = [];
        }
        return view('bkstar123_bkscms_adminpanel::permissions.index', compact('permissions'));
    }

    /**
     * Show create form
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->capabilityCheck('create', Permission::class);
        return view('bkstar123_bkscms_adminpanel::permissions.create');
    }

    /**
     * Store a resource
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Http\Requests\StorePermission $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermission $request)
    {
        $this->capabilityCheck('create', Permission::class);
        try {
            $permission = Permission::create($request->all());
            flashing("New permission $permission->alias has been created")
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
     * @param \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        $this->capabilityCheck('view', $permission);
        return view('bkstar123_bkscms_adminpanel::permissions.show', compact('permission'));
    }

    /**
     * Update a resource
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Http\Requests\UpdatePermission $request
     * @param \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermission $request, Permission $permission)
    {
        $this->capabilityCheck('update', $permission);
        try {
            $permission->update($request->all());
            flashing("The permission $permission->alias's metadata has been successfully updated")
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
     * @param \Blstar123\BksCMS\AdminPanel\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $this->capabilityCheck('delete', $permission);
        try {
            $permission->delete();
            flashing("The permission $permission->alias has been successfully removed")
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back()->getTargetUrl() != route('permissions.show', [
            'permission' => $permission->{$permission->getRouteKeyName()}
        ]) ? back() : redirect()->route('permissions.index');
    }
    
    /**
     * Destroy multiple resources
     *
     * @return \Illuminate\Http\Response
     */
    public function massiveDestroy()
    {
        $this->capabilityCheck('massiveDelete', Permission::class);
        $Ids = explode(',', request()->input('Ids'));
        try {
            Permission::destroy($Ids);
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
     * Disabling the given permission
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function offStatus(Permission $permission)
    {
        $this->capabilityCheck('deactivate', $permission);
        $permission->status = Permission::DISABLED;
        try {
            $permission->save();
            flashing("The permission $permission->alias has been successfully disabled")
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
     * Enabling the given permission
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function onStatus(Permission $permission)
    {
        $this->capabilityCheck('activate', $permission);
        $permission->status = Permission::ENABLED;
        try {
            $permission->save();
            flashing("The permission $permission->alias has been successfully enabled")
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
