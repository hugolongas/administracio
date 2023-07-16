<?php

namespace App\Http\Controllers;

use App\Vot;
use App\Concurs;
use App\Project;
use App\Soci;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Notification;
use Validator;
use Redirect;
use Response;

class VotController extends Controller
{
        public function index()
    {
        //
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    
    public function voteContest($id)
    {
        $soci = Auth::user()->soci;
        if($soci!=null){
            $vot = Vot::Where([
                ['concurs_id', '=', $id],
                ['soci_id', '=', $soci->id],
            ])->first();
            if($vot==null){
                $concurs = Concurs::findOrFail($id);
                $startVotationsDate = new DateTime($concurs->start_votations_date);
                $dateNow = new DateTime();
                if($startVotationsDate<=$dateNow)
                {
                    $endVotationsDate = new DateTime($concurs->end_votations_date);     
                    if($endVotationsDate>=$dateNow)
                    {
                        return view('votacions.votacio')->with('concurs', $concurs);
                    }
                    else{
                        Notification::warning('La votació ja ha finalitzat');
                        return Redirect::back();
                    }
                }
                else{
                    Notification::warning('La votació encara no ha començat');
                    return Redirect::back();
                }
            }
            Notification::warning('Ja has votat en aquest concurs');
            return Redirect::back();
        }
        if(Auth::user()->isAdmin())
        {
            $concurs = Concurs::findOrFail($id);
            return view('concurs.votacioAdmin')->with('concurs', $concurs);
        }
    }

    public function voteStore(request $request){
        $validator = Validator::make($request->all(), [
            'project_vote' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }
        $idProject = $request->input('project_vote');
        $idConcurs = $request->input('idConcurs');
        Project::findOrFail($idProject)->increment('vots_soci');

        $vot = new Vot;
        $vot->project_id = $idProject;
        $vot->concurs_id = $idConcurs;
        $soci = Auth::user()->soci;
        $vot->soci_id = $soci->id;
        $vot->save();

        Notification::success('Has votat al projecte');
        return redirect()->route('votacions');
    }

    public function voteStoreAdmin(request $request){
        $validator = Validator::make($request->all(), [
            'project_vote' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }
        $dni =  $request->input('dni');
        $idContest = $request->input('idConcurs');
        $soci = Soci::Where('dni', 'like', '%' . $dni . '%')->first();
        if($soci!=null){
            $vot = Vot::Where([
                ['concurs_id', '=', $idContest],
                ['soci_id', '=', $soci->id],
            ])->first();
            if($vot==null){
                $idProject = $request->input('project_vote');        
                Project::findOrFail($idProject)->increment('vots_soci');        
                $vot = new Vot;
                $vot->project_id = $idProject;
                $vot->concurs_id = $idContest;
                $vot->soci_id = $soci->id;
                $vot->save();        
                Notification::success('projecte votat');
            }
            else{
                
            }
            Notification::danger('Aquest soci ja ha votat en el concurs');
            return Redirect::back();
            
        }        
        return Redirect::back()->withErrors(['dni_incorrecte'=>'dni_incorrecte'])
                ->withInput();
    }

    public function voteMailAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dni' => 'required',  
            'project_vote' => 'required'
        ]);
        $json = new \stdClass();
        if($validator->fails())
        {
            $json->success = false;
            $json->errors = $validator->errors();
        }
        else
        {
            $dni =  $request->input('dni');
            $idContest = $request->input('idConcurs');
            $soci = Soci::Where('dni', 'like', '%' . $dni . '%')->first();
            if($soci!=null){
                $vot = Vot::Where([
                    ['concurs_id', '=', $idContest],
                    ['soci_id', '=', $soci->id],
                ])->first();
                if($vot==null){
                    $idProject = $request->input('project_vote');        
                    Project::findOrFail($idProject)->increment('vots_soci');        
                    $vot = new Vot;
                    $vot->project_id = $idProject;
                    $vot->concurs_id = $idContest;
                    $vot->soci_id = $soci->id;
                    $vot->save();        
                    $json->success = true;
                }
                else{
                    $json->success = false;
                    $json->errors = $validator->errors()->add('vot', 'Aquest soci ja ha votat');;
                }
            }    
            else{
                $json->success = false;
                $json->errors = $validator->errors()->add('soci', 'No existeix aquest soci');;
            }        
        }
        return Response::json($json);
    }

    public function voteMesaAdmin(Request $request)
    {
        $json = new \stdClass();
        $concursId = $request->input('concurs_id');
        $projects = Project::where('concurs_id', '=', $concursId)->get();
        foreach($projects as $project)
        {
            $mesa_value = $request->input('project_vote_'.$project->id);
            if($mesa_value!=null){
                $project->vots_mesa = $mesa_value;
                $project->save();
            }
        }
        $json->success = true;
        return Response::json($json);
    }

}