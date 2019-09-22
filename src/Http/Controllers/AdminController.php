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
                    ->paginate(config('bkstar123_bkscms_adminpanel.pageSize'))
                    ->appends([
                        'search' => $searchText
                    ]);
        } catch (Exception $e) {
            $admins = [];
        }
        return view('bkstar123_bkscms_adminpanel::admins.index', compact('admins'));
    }
}
