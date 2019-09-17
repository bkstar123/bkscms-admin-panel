<?php

namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Bkstar123\BksCMS\Utilities\Traits\EloquentSearch;

class AdminController extends Controller
{
    use EloquentSearch;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = $this->filterBySearchKeyword(
            Admin::class,
            config('bkstar123_bkscms_adminpanel.pageSize'),
            ['name', 'username', 'email']
        );
        return view('bkstar123_bkscms_adminpanel::admins.index', compact('admins'));
    }
}
