<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promotor;
use App\User;
use App\Role;
use Yajra\Datatables\Datatables;
use Notification;

class PromotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('promotors.index');
    }
    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $promotors = Promotor::all();
        return Datatables::of($promotors)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('promotors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $promotor_name = $request['promotor_name'];
        $promotor_desc = $request['promotor_desc'];
        $user_name = $request['user_name'];
        $user_email = $request['user_email'];
        $user_password = $request['user_password'];
        $promotor = new Promotor();
        $promotor->promotor_name = $promotor_name;
        $promotor->description = $promotor_desc;
        $promotor->save();
        $role = Role::find(4);
        $promotor->roles()->attach($role);

        $user = new User;
        $user->name = $promotor_name;
        $user->username = $user_name;
        $user->email = $user_email;
        $user->password = bcrypt($user_password);
        $user->save();

        $promotor->users()->attach($user);

        Notification::success("S'ha creat una nou promotor");
        return redirect()->route('promotors');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promotor = Promotor::findOrFail($id);
        return view('promotors.show')->with('promotor',$promotor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seccio  $seccio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $promotor = Promotor::findOrFail($id);
        return view('promotors.edit')->with('promotor',$promotor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $promotor_description = $request['promotor_desc'];
        $promotor = Promotor::findOrFail($request->id);
        $promotor->description = $promotor_description;
        $promotor->save();
        Notification::success("S'ha actualitzat al promotor");
        return redirect()->route('promotors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $promotor = Promotor::findOrFail($id);
        $user = User::where('name', $promotor->promotor_name)->firstOrFail();


        $promotor->roles()->detach();
        $promotor->users()->detach();
        $promotor->delete();
        $user->delete();
    }
}
