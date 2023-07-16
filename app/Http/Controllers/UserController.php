<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\User;


use Notification;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
	{
		if ($request->ajax()) {
            $users = User::whereNull('soci_id')->get();			

            return Datatables::of($users)
                ->addColumn('edit', function ($row) {
                    $url = route('users.edit', ['id' => $row->id]);
                    $btn = '<a href="' . $url . '" class="edit btn btn-outline-primary">Editar</a>';
                    if($row->finished)
                    $btn = '<button class="edit btn btn-outline-primary" disabled>Editar</button>';
                    return $btn;
                })->addColumn('view', function ($row) {
                    $url = route('users.show', ['id' => $row->id]);
                    $btn = '<a href="' . $url . '" class="view btn btn-outline-primary">Veure</a>';                    
                    return $btn;
                })->addColumn('activate',function($row){  
                    if($row->active)
                    {
                        $btn = '<button class="btn btn-danger" accion="activar">Desactivar</button>';
                    }
                    else
					{
						$btn =  '<button class="btn btn-success" accion="activar">Activar</button>';
                    }
                    return $btn;
                })->addColumn('delete',function($row){
                    $btn = '<button class="btn btn-outline-danger" accion="delete">Eliminar</button>';
                    if($row->active)
                    $btn = '<button class="btn btn-outline-danger" accion="delete" disabled>Eliminar</button>';
                    return $btn;
                })
                ->rawColumns(['view', 'edit', 'activate','delete'])->make(true);
        }      
		return view('user.index');
	} 

	public function show($id){
		$user = User::findOrFail($id);
		return view('user.show')->with('user',$user);
	}

    public function create()
	{
		return view('user.create');
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
            'username' => 'required',
            'email' => 'required',
			'password' => 'required'        
			]);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		}
		$name = $request->input('name');
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        
		if(User::where('username',$username)->first()==null){			
				$user = new User;
				$user->name = $name;
				$user->username = $username;
				$user->email = $email;
				$user->password = bcrypt($password);
				$user->save();	
				Notification::success('Usuari Creat Correctament');
		}		
		
		return redirect()->route('users');
	}

	public function edit($id){
		$user = User::findOrFail($id);
		return view('user.edit')->with('user',$user);
	}

	public function update(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required',            
            'email' => 'required',
			]);
			
			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator)
					->withInput();
			}
			$name = $request->input('name');
			$email = $request->input('email');

			$user = User::findOrFail($request->id);
			$user->name = $name;
			$user->email = $email;
			$user->save();
			
			Notification::success('Usuari actualitzat Correctament');

			return redirect()->route('users');
	}

	public function activate($id){
		$user = User::findOrFail($id);
		$user->active = ($user->active==1)?0:1;
		$user->save();
		
        return $user->active;
	}

	public function delete($id)
	{
		$user = User::findOrFail($id);
		$user->delete();
	}
	
}
