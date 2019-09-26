<?php

namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bkstar123\BksCMS\AdminPanel\Admin;

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
     * Disabling the given admin account
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
