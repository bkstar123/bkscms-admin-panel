<?php

namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers;

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
        $admins = Admin::paginate(config('bkstar123_bkscms_adminpanel.pageSize'));
        return view('bkstar123_bkscms_adminpanel::admins.index', compact('admins'));
    }
}
