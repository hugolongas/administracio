<?php

namespace App\Http\Controllers;

use App\Section;
use App\User;
use App\Soci;
use App\Role;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Notification;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sections.index');
    }
    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $sections = Section::all()->whereNotIn('id',[1,2]);
        return Datatables::of($sections)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $section_name = $request['section_name'];
        $section_description = $request['section_desc'];
        $user_name = $request['user_name'];
        $user_email = $request['user_email'];
        $user_password = $request['user_password'];
        $section = new Section();
        $section->section_name = $section_name;
        $section->description = $section_description;
        $section->save();
        $role = Role::find(3);
        $section->roles()->attach($role);

        $user = new User;
        $user->name = $section_name;
        $user->username = $user_name;
        $user->email = $user_email;
        $user->password = bcrypt($user_password);
        $user->save();

        $section->users()->attach($user);

        Notification::success("S'ha creat una nova secció");
        return redirect()->route('sections');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = Section::findOrFail($id);
        return view('sections.show')->with('section',$section);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seccio  $seccio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section = Section::findOrFail($id);
        return view('sections.edit')->with('section',$section);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $section_description = $request['section_desc'];
        $section = Section::findOrFail($request->id);
        $section->description = $section_description;
        $section->save();
        Notification::success("S'ha actualitzat la secció");
        return redirect()->route('sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $section = Section::findOrFail($id);
        $user = User::where('name', $section->section_name)->get();


        $section->roles()->detach();
        $section->users()->detach();
        $section->delete();
        $user[0]->delete();
    }

    //Seccions
	public function socisNotInSection($idSection)
	{
		$section = Section::findOrFail($idSection);
		$sectionUsers = $section->users;
		$socisId = array();
		foreach($sectionUsers as $user)
		{
			$soci = $user->soci;
			if($soci!=null)
			$socisId[] = $soci->id;
        }
        $usersId = User::pluck('soci_id')->all();
        $socis = Soci::select('id','member_number','name','surname','second_surname')
        ->whereNotIn('id', $socisId)
        ->where('unregister_date',NULL)
        ->whereIn('id',$usersId)->get(); 
		return Datatables::of($socis)->make(true);
    }
    
    public function attachSocis(Request $request)
    {
        $section = Section::findOrFail($request->id);
        $usersInSection = $section->users;
        $idSocis = $request["idSocis"];
        $socisId = json_decode($idSocis);
        foreach($socisId as $sociId)
        {
            $idSoci = intval($sociId);
            $user = User::where('soci_id',$idSoci)->get();
            $section->users()->attach($user);
        }
        Notification::success("S'ha afegit un soci en la secció");
        return "done";
    }

    public function detachSoci(Request $request)
    {
        $id = $request->id;
        $userId = $request->userId;
        $section = Section::findOrFail($id);
        $section->users()->detach($userId);
        Notification::success("S'ha eliminat un soci de la secció");
    }
}
