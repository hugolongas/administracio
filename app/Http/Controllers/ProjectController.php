<?php

namespace App\Http\Controllers;

use App\Project;
use App\Concurs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

use Storage;
use Response;
use Notification;
use Validator;
use Redirect;
use DateTime;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Project::where('concurs_id', '=', $request->id)->get();
            return Datatables::of($data)->make(true);
        }

        $concurs = Concurs::findOrFail($request->id);
        $startVotationsDate = new DateTime($concurs->start_votations_date);        
        $concurs->start_votations_date = $startVotationsDate->format('d/m/Y H:i');

        $endVotationsDate = new DateTime($concurs->end_votations_date);        
        $concurs->end_votations_date = $endVotationsDate->format('d/m/Y H:i');
        return view('concurs.addProjects')->with('concurs', $concurs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $validator = Validator::make($request->all(), [
            'projectName' => 'required'            
        ]);
        if($validator->fails())
        {
            $json = new \stdClass();
            $json->success = false;
            $json->errors = $validator->errors();
        }
        else
        {
            $idConcurs = $request->id;
            $projectName = $request->projectName;            
            $projectUrl = "";            
            if ($request->hasfile('projectFile')) {
                $path = '/concursos/'.$idConcurs.'/';
                if(!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path, 0775, true); //creates directory
                }
                $file = $request->file('projectFile');
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(8) . date('Ymdhm');
                $file_name = $fileName . '.'.$extension;
                
                $projectUrl = $path . $file_name;
                Storage::disk('public')->put($projectUrl,file_get_contents($file));
            }
            
            $project = new Project;
            $project->concurs_id = $idConcurs;
            $project->project_name = $projectName;
            $project->project_url = $projectUrl;
            $project->project_file = $projectUrl;
            $project->vots_mesa = 0;
            $project->vots_mesa_total = 0;
            $project->vots_soci = 0;
            $project->vots_soci_total = 0;
            $project->vots_total = 0;
            $project->save();
            $json = new \stdClass();
            $json->success = true;


        }
        return Response::json($json);
    }    

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $json = new \stdClass();
            $json->success = true;
            $json->project = $project;
            return Response::json($json);
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
            'editProjectName' => 'required'            
        ]);
        if($validator->fails())
        {
            $json = new \stdClass();
            $json->success = false;
            $json->errors = $validator->errors();
        }
        else
        {
            $id = $request->id;
            $project = Project::find($id);  

            $projectName = $request->editProjectName;            
            
            $projectUrl = "";            
            if ($request->hasfile('editProjectFile')) {
                $path = '/concursos/'.$project->concurs_id.'/';
                if(!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path, 0775, true); //creates directory
                }   
                $file = $request->file('editProjectFile');             
                $projectUrl = $project->project_url;
                if($projectUrl==null || ctype_space($projectUrl)){
                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::random(8) . date('Ymdhm');
                    $file_name = $fileName . '.'.$extension;                
                    $projectUrl = $path . $file_name;
                    $project->project_url = $projectUrl;                    
                    $project->project_file = $file_name;
                }
                Storage::disk('public')->put($projectUrl,file_get_contents($file));
            }           
            
            $project->project_name = $projectName;            
            $project->save();
            $json = new \stdClass();
            $json->success = true;
        }
        return Response::json($json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $project = Project::find($id); 
        $fileUrl = $project->project_url;
        Storage::disk('public')->delete($fileUrl);
        $project->delete();
    }
}
