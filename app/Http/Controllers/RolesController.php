<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Role;
use Notification;

class RolesController extends Controller
{
    public function index()
    {
        return view('roles.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        return Datatables::of(Role::all())->make(true);
    }
}
