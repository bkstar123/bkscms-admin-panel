<?php

namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Bkstar123\BksCMS\AdminPanel\Http\Requests\StoreAdmin;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        try {
            $admin = Admin::create($request->all());
            flashing("New admin account for $admin->email has been created")
                ->success()
                ->flash();
            return back();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
            return back();
        }
    }

    /**
     * Show a resource
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
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
        return back();
    }
    
    /**
     * Destroy multiple resources
     *
     * @return \Illuminate\Http\Response
     */
    public function massiveDestroy()
    {
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
}
