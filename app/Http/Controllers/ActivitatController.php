<?php

namespace App\Http\Controllers;

use App\Activitat;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use App\Soci;
use Notification;
use Validator;
use Redirect;

class ActivitatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('activitats.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        return Datatables::of(Activitat::all())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('activitats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'activityDate' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }
        $name = $request->input('name');
        $activityDate = $request->input('activityDate');
        $description = $request->input('description');
        if ($description == null)
            $description = "";

        $activitat = new Activitat;
        $activitat->name = $name;
        $activitat->activity_date = $activityDate;
        $activitat->description = $description;
        $activitat->num_socis = 0;
        $activitat->num_nosocis = 0;
        $activitat->save();

        $inseredID = $activitat->id;

        return redirect()->route('activitats.show', $inseredID);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activitat  $activitat
     * @return \Illuminate\Http\Response
     */
    public function show(Activitat $activitat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activitat  $activitat
     * @return \Illuminate\Http\Response
     */
    public function edit(Activitat $activitat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request     
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'activityDate' => 'required'
        ]);
        
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		}
        $name = $request->input('name');
        $activityDate = $request->input('activityDate');
        $description = $request->input('description');
        if ($description == null)
            $description = "";

        $activitat_id = $request->id;
        $activitat = Activitat::findOrFail($activitat_id);
        $activitat->name = $name;
        $activitat->activity_date = $activityDate;
        $activitat->description = $description;
        $activitat->num_socis = 0;
        $activitat->num_nosocis = 0;
        $activitat->save();
        
        Notification::success('Activitat actualitzada correctament');
		return redirect()->route('activitats');
    }

    public function delete($id)
	{
		$activitat = Activitat::findOrFail($id);
		$activitat->delete();
    }
    
    public function registerAccess(Request $request)
    {
        
    }

}
