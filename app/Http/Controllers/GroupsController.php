<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use App\Soci;
use App\Role;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Notification;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $groups = Group::all()->whereNotIn('id',[1,2]);
            
            return Datatables::of($groups)
                ->addColumn('edit', function ($row) {
                    $url = route('groups.edit', ['id' => $row->id]);
                    $btn = '<a href="' . $url . '" class="edit btn btn-outline-primary">Editar</a>';                    
                    return $btn;
                })->addColumn('view', function ($row) {
                    $url = route('groups.show', ['id' => $row->id]);
                    $btn = '<a href="' . $url . '" class="view btn btn-outline-primary">Veure</a>';                    
                    return $btn;
                })->addColumn('members', function ($row) {
                    $userCount = count($row->users);
                    return $userCount;
                })->addColumn('delete',function($row){
                    $btn = '<button class="btn btn-outline-danger" accion="delete">Eliminar</button>';                    
                    return $btn;
                })
                ->rawColumns(['view','members', 'edit','delete'])->make(true);
        }
        return view('groups.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request['name'];
        $description = $request['desc'];        
        
        $group = new Group();
        $group->name = $name;
        $group->description = $description;
        $group->save();
        $role = Role::find(3);
        $group->roles()->attach($role);

        Notification::success("S'ha creat una nou grup");
        return redirect()->route('groups');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::findOrFail($id);
        return view('groups.show')->with('group',$group);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seccio  $seccio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);        
        return view('groups.edit')->with('group',$group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $group_description = $request['group_desc'];
        
        $group = Group::findOrFail($request->id);
        $group->description = $group;
        $group->save();

        Notification::success("S'ha actualitzat el grup");
        return redirect()->route('groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $group = Group::findOrFail($id);

        $group->roles()->detach();
        $group->users()->detach();
        $group->delete();
    }

    //Seccions
	public function usersNotInGroup($id)
	{
		$group = Group::findOrFail($id);
		$groupUsers = $group->users;
		$usersId = array();
		foreach($groupUsers as $user)
		{
			$usersId[] = $user->id;
        }        

        $users = User::select('id','name')
        ->whereNotIn('id', $usersId)
        ->where('active',1); 
		return Datatables::of($users)->make(true);
    }
    
    public function attachUser(Request $request)
    {
        $group = Group::findOrFail($request->id);
        $usersInGroup = $group->users;
        $usersId = json_decode($request["idUsers"]);
        foreach($usersId as $userId)
        {
            $user = User::where('id',intval($userId))->get();
            $group->users()->attach($user);
        }
        Notification::success("S'ha afegit un usuari al grup");
        return "done";
    }

    public function detachUser(Request $request)
    {
        $id = $request->id;
        $userId = $request->userId;
        $group = Group::findOrFail($id);
        $group->users()->detach($userId);
        Notification::success("S'ha eliminat un usuari del grup");
    }
}
