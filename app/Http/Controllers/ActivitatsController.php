<?php

namespace App\Http\Controllers;

use App\Activitat;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Section;
use App\Soci;

use Notification;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivitatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $activities = $this->_getActivities();
            return Datatables::of($activities)->make(true);
        }
        return view('activitats.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $sections = Section::all();
        return view('activitats.create')->with('user', $user)->with('sections', $sections);
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
        $createdBy = $request->input('created_by');
        if ($description == null)
            $description = "";

        $activitat = new Activitat;
        $activitat->name = $name;
        $activitat->activity_date = $activityDate;
        $activitat->description = $description;
        $activitat->socis_tickets = 0;
        $activitat->nosocis_tickets = 0;
        $activitat->created_by = $createdBy;
        if (Auth::user()->isAdmin())
            $activitat->status = 'aproved';
        else
            $activitat->status = 'pending';
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
    public function show($id)
    {
        $activity = Activitat::findOrFail($id);
        return view('activitats.show')->with('activity', $activity);
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

    public function ActivitiesList(Request $request)
    {
        if ($request->ajax()) {
            $activities = $this->_getActivities('aproved');
            return Datatables::of($activities)->make(true);
        }
        return view('activitats.ticketControlList');
    }

    public function checkTickets($id)
    {
        $activity = Activitat::findOrFail($id);
        return view('activitats.ticketControl')->with('activity', $activity);
    }



    /*Functions*/
    public function registerTicket(Request $request)
    {
        $sociId = $request['sociId'];
        $activityId = $request['activityId'];
        $activity = Activitat::findOrFail($activityId);
        if ($sociId == 0) {

            $activity->nosocis_tickets = $activity->nosocis_tickets + 1;
            $activity->save();
        } else {
            $activity->socis_tickets = $activity->socis_tickets + 1;
            $activity->save();
            $soci = Soci::find($sociId);
            $activity->socis()->attach($sociId);
        }
    }

    public function checkSoci(Request $request)
    {
        $type = $request['type'];
        $parm = $request['param'];
        $result = "";
        if ($type == 'dni') {
            $result = DB::select("CALL `soci_by_dni`('" . $parm . "')");
        } else {
            $result = DB::select("CALL `soci_by_name`('" . $parm . "')");
        }
        return response()->json([$result]);
    }

    public function getActivities($status = 'all')
    {
        return $this->_getActivities($status);
    }

    private function _getActivities($status = 'all')
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return Activitat::all();
        }
        
        if ($user->isControl()) {
            return Activitat::all();
        }

        $creator = array();
        $name = $user->name;
        $creator[] = $name;
        $sections = $user->sections;
        foreach ($sections as $s) {
            $section_name = $s->section_name;
            if ($section_name != "soci") {
                $creator[] = $section_name;
            }
        }
        if ($status == 'all') {
            $activitats = Activitat::whereIn('created_by', $creator);
        } else {
            $activitats = Activitat::whereIn('created_by', $creator)->where('status', '=', $status);
        }
        return $activitats->get();
    }
}
