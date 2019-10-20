<?php
/**
 * AdminController
 *
 * @author: tuanha
 * @last-mod: 06-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Bkstar123\BksCMS\AdminPanel\Http\Requests\StoreAdmin;
use Bkstar123\BksCMS\AdminPanel\Traits\AuthorizationShield;
use Bkstar123\BksCMS\AdminPanel\Http\Requests\ChangePassword;

class AdminController extends Controller
{
    use AuthorizationShield;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->capabilityCheck('index', Admin::class);
        $searchText = request()->input('search');
        try {
            $admins = Admin::search($searchText)
                    ->simplePaginate(config('bkstar123_bkscms_adminpanel.pageSize'))
                    ->appends([
                        'search' => $searchText
                    ]);
        } catch (Exception $e) {
            $admins = [];
        }
        return view('bkstar123_bkscms_adminpanel::admins.index', compact('admins'));
    }

    /**
     * Show create form
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->capabilityCheck('create', Admin::class);
        return view('bkstar123_bkscms_adminpanel::admins.create');
    }

    /**
     * Store a resource
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Http\Requests\StoreAdmin $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdmin $request)
    {
        $this->capabilityCheck('create', Admin::class);
        try {
            $data = $request->all();
            $data['password'] = bcrypt($request->password);
            $admin = Admin::create($data);
            flashing("New admin account for $admin->email has been created")
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
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        $this->capabilityCheck('view', $admin);
        return view('bkstar123_bkscms_adminpanel::admins.show', compact('admin'));
    }

    /**
     * Destroy a resource
     *
     * @param \Blstar123\BksCMS\AdminPanel\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $this->capabilityCheck('delete', $admin);
        try {
            $admin->delete();
            flashing("The account $admin->email has been successfully removed")
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back()->getTargetUrl() != route('admins.show', [
            'admin' => $admin->{$admin->getRouteKeyName()}
        ]) ? back() : redirect()->route('admins.index');
    }
    
    /**
     * Destroy multiple resources
     *
     * @return \Illuminate\Http\Response
     */
    public function massiveDestroy()
    {
        $this->capabilityCheck('massiveDelete', Admin::class);
        $Ids = explode(',', request()->input('Ids'));
        try {
            Admin::destroy($Ids);
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
     * Disabling the given admin account
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function offStatus(Admin $admin)
    {
        $this->capabilityCheck('deactivate', $admin);
        $admin->status = Admin::INACTIVE;
        try {
            $admin->save();
            flashing("The account $admin->email has been successfully disabled")
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
     * Enabling the given admin account
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function onStatus(Admin $admin)
    {
        $this->capabilityCheck('activate', $admin);
        $admin->status = Admin::ACTIVE;
        try {
            $admin->save();
            flashing("The account $admin->email has been successfully enabled")
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
     * Update password
     *
     * @param \Bkstar123\BksCMS\AdminPanel\Http\Requests\ChangePassword $request
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function changePassword(ChangePassword $request, Admin $admin)
    {
        $this->capabilityCheck('changePassword', $admin);
        $admin->password = bcrypt($request->password);
        try {
            $admin->save();
            flashing("The password for account $admin->email has been successfully updated")
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
