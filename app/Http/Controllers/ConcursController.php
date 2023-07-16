<?php

namespace App\Http\Controllers;

use App\Concurs;
use App\Project;
use App\Vot;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use Notification;
use Validator;
use Redirect;
use DateTime;
use Storage;


class ConcursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Concurs::orderBy('updated_at','desc')->get();

            return Datatables::of($data)
                ->addColumn('edit', function ($row) {
                    $url = route('concurs.edit', ['id' => $row->id]);
                    $btn = '<a href="' . $url . '" class="edit btn btn-outline-primary">Editar</a>';
                    if($row->finished)
                    $btn = '<button class="edit btn btn-outline-primary" disabled>Editar</button>';
                    return $btn;
                })->addColumn('view', function ($row) {
                    $url = route('concurs.admin_show', ['id' => $row->id]);
                    $btn = '<a href="' . $url . '" class="view btn btn-outline-primary">Veure</a>';                    
                    return $btn;
                })->addColumn('winner', function ($row) {
                    $idProj = $row->id_winner;
                    if($idProj!=null){
                        $project = Project::findOrFail($idProj);     
                        if($project!=null)
                        {
                            return $project->project_name;
                        }
                    }
                    return "";
                })->addColumn('end_contest', function ($row) {
                    $url = route('concurs.close', ['id' => $row->id]);
                    $btn = '<a href="' . $url . '" class="view btn btn-outline-primary ">Finalitzar Concurs</a>';
                    if($row->finished)
                    $btn = '<button class="view btn btn-outline-primary" disabled>Finalitzar Concurs</button>';
                    return $btn;
                })->addColumn('projects', function ($row) {
                    $projects = $row->projects;
                    if($projects!=null){
                        return $projects->count();
                    }
                    return 0;
                })->addColumn('activate',function($row){                    
                    $disabled = "";
                    if($row->finished)
                    $disabled = 'disabled';                    
                    if($row->active)
                    {
                        $btn = '<button class="btn btn-danger" accion="activar" '.$disabled.'>Desactivar</button>';
                    }
                    else
					{
						$btn =  '<button class="btn btn-success" accion="activar" '.$disabled.'>Activar</button>';
                    }
                    return $btn;
                })->addColumn('delete',function($row){
                    $btn = '<button class="btn btn-outline-danger" accion="delete">Eliminar</button>';
                    if($row->finished)
                    $btn = '<button class="btn btn-outline-danger" accion="delete" disabled>Eliminar</button>';
                    return $btn;
                })
                ->rawColumns(['view', 'edit', 'winner', 'end_contest','projects','activate','delete'])->make(true);
        }
        return view('concurs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('concurs.create');
    }    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'startVotationsDate' => 'required',
            'endVotationsDate' => 'required',
            'puntsMesa' => 'required',
            'mesaPercent' => 'required|integer|between:0,100',
            'sociPercent' => 'required|integer|between:0,100'
        ]);
        
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }
        $name = $request->input('name');
        $password = $request->input('password_contest');
        $description = $request->input('description');
        $startVotationsDate = $request->input('startVotationsDate');
        $startVotationsDate =DateTime::createFromFormat("d/m/Y H:i", $startVotationsDate);        
        $endVotationsDate = $request->input('endVotationsDate');
        $endVotationsDate = DateTime::createFromFormat("d/m/Y H:i", $endVotationsDate);
        $puntsMesa = $request->input('puntsMesa');
        $mesaPercent = $request->input('mesaPercent');
        $sociPercent = $request->input('sociPercent');

        if($password==null)
        {
            $password = $this->_createPassword();
        }
        $concurs = new Concurs;
        $concurs->name = $name;
        $concurs->password = $password;
        $concurs->description = $description;
        $concurs->start_votations_date = $startVotationsDate;
        $concurs->end_votations_date = $endVotationsDate;
        $concurs->punts_mesa = $puntsMesa;
        $concurs->mesa_percent = $mesaPercent;
        $concurs->soci_percent  = $sociPercent;
        $concurs->active = 0;
        $concurs->finished = 0;
        $concurs->save();

        $inseredID = $concurs->id;


        Notification::success('Concurs creat correctament');
        if ($request->has('crear_continuar')) {
            return redirect()->route('concurs.edit', $inseredID);
        } else {
            return redirect()->route('concurs');
        }
    }

    public function show($id)
    {
        $concurs = Concurs::findOrFail($id);
        $startVotationsDate = new DateTime($concurs->start_votations_date);        
        $concurs->start_votations_date = $startVotationsDate->format('d/m/Y H:i');

        $endVotationsDate = new DateTime($concurs->end_votations_date);        
        $concurs->end_votations_date = $endVotationsDate->format('d/m/Y H:i');
        $winnerName = "";
        if($concurs->finished){
            $winner = $concurs->projects()->where('id',$concurs->id_winner)->first();
            $winnerName = $winner->project_name;
        }        
        return view('concurs.show')->with('concurs', $concurs)->with('winner',$winnerName);
    }

    public function edit($id)
    {
        $concurs = Concurs::findOrFail($id);
        $startVotationsDate = new DateTime($concurs->start_votations_date);        
        $concurs->start_votations_date = $startVotationsDate->format('d/m/Y H:i');

        $endVotationsDate = new DateTime($concurs->end_votations_date);        
        $concurs->end_votations_date = $endVotationsDate->format('d/m/Y H:i');
        return view('concurs.edit')->with('concurs', $concurs);
    }
   
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'startVotationsDate' => 'required',
            'endVotationsDate' => 'required',
            'puntsMesa' => 'required',
            'mesaPercent' => 'required|integer|between:0,100',
            'sociPercent' => 'required|integer|between:0,100'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }
        $name = $request->input('name');
        $password = $request->input('password_contest');
        $description = $request->input('description');
        $startVotationsDate = $request->input('startVotationsDate');
        $startVotationsDate =DateTime::createFromFormat("d/m/Y H:i", $startVotationsDate);        
        $endVotationsDate = $request->input('endVotationsDate');
        $endVotationsDate = DateTime::createFromFormat("d/m/Y H:i", $endVotationsDate);
        $puntsMesa = $request->input('puntsMesa');
        $mesaPercent = $request->input('mesaPercent');
        $sociPercent = $request->input('sociPercent');

        $concursId = $request->id;
        $concurs = Concurs::findOrFail($concursId);
        $concurs->name = $name;
        if($password!=$concurs->password){
            $concurs->password = $password;
        }
        $concurs->description = $description;
        $concurs->start_votations_date = $startVotationsDate;
        $concurs->end_votations_date = $endVotationsDate;
        $concurs->punts_mesa = $puntsMesa;
        $concurs->mesa_percent = $mesaPercent;
        $concurs->soci_percent  = $sociPercent;
        $concurs->save();

        Notification::success('Concurs actualitzat correctament');
        return redirect()->route('concurs');
    }

    public function delete($id)
    {
        $concurs = Concurs::findOrFail($id);
        if(!$concurs->finished && !$concurs->active){
            $projects = Project::Where('concurs_id',$id)->get();
            foreach($projects as $project){
                $fileUrl = $project->project_url;
                Storage::disk('public')->delete($fileUrl);
                $project->delete();
            }
            $concurs->delete();
        }
    }

    public function activate($id)
    {
        $concurs = Concurs::findOrFail($id);
        $active = $concurs->active;
        if ($active == 0)
            $concurs->active = 1;
        else
            $concurs->active = 0;
        $concurs->save();
        return $concurs->active;
    }

    public function endContest(Request $request)
    {

        if ($request->ajax()) {            
            $concurs = Concurs::findOrFail($request->id);            
            $punts_mesa = $concurs->punts_mesa;
            $mesa_percent = $concurs->mesa_percent;
            $soci_percent = $concurs->soci_percent;
            $projects = $concurs->projects;

            $vots = Vot::Where('concurs_id',$request->id)->get();    
            $total_vots = $vots->count();
            if($total_vots>0){
                foreach($projects as $project)
                {
                    //Vots Mesa
                    $vot_mesa =  $project->vots_mesa;
                    $vots_mesa_relatius =  $vot_mesa/$punts_mesa;                
                    $vots_mesa_total = $vots_mesa_relatius * $mesa_percent;
                    $project->vots_mesa_total = $vots_mesa_total;
    
                    //Vots Soci
                    $vots_soci = $vots->where('project_id','=',$project->id)->count();                
                    $project->vots_soci =  $vots_soci;
                    $vots_soci_relatius =  $vots_soci/$total_vots;                
                    $vots_soci_total = $vots_soci_relatius * $soci_percent;
                    $project->vots_soci_total = $vots_soci_total;                
                    
                    $project->vots_total = $vots_soci_total + $vots_mesa_total;
                    $project->save();
                }
            }
            
            return Datatables::of($projects)->make(true);
        }

        $concurs = Concurs::findOrFail($request->id);
        $startVotationsDate = new DateTime($concurs->start_votations_date);        
        $concurs->start_votations_date = $startVotationsDate->format('d/m/Y H:i');

        $endVotationsDate = new DateTime($concurs->end_votations_date);        
        $concurs->end_votations_date = $endVotationsDate->format('d/m/Y H:i');        

        return view('concurs.endContest')->with('concurs', $concurs);
    }

    public function finishContest($id)
    {
        $concurs = Concurs::findOrFail($id);
        $projects = $concurs->projects()->orderBy('vots_total','DESC')->get();
        $winnerProject = $projects->first();
        $concurs->id_winner = $winnerProject->id;
        $concurs->finished = 1;
        $concurs->save();

        Notification::success('Concurs Finalitzat');
        return redirect()->route('concurs.admin_show', $concurs->id);
    }


    //Socis
    public function contestSocis(Request $request)
    {
        if ($request->ajax()) {
            $data = Concurs::orderBy('updated_at','desc')->get();

            return Datatables::of($data)
                ->addColumn('view', function ($row) {
                    $url = route('votacions.show', ['id' => $row->id]);
                    $btn = '<a href="' . $url . '" class="view btn btn-outline-primary">Veure</a>';                                        
                    return $btn;
                })->addColumn('vote', function ($row) {
                    $url = route('votacions.vote', ['id' => $row->id]);
                    $btn = '<a href="' . $url . '" class="view btn btn-outline-primary">Votar</a>';
                    if($row->finished)
                    $btn = '<button class="view btn btn-outline-primary" disabled>Votat</button>';
                    return $btn;
                })
                ->rawColumns(['view', 'vote'])->make(true);
        }
        return view('votacions.index');
    }

    public function showSoci($id)
    {
        $concurs = Concurs::findOrFail($id);
        $startVotationsDate = new DateTime($concurs->start_votations_date);        
        $concurs->start_votations_date = $startVotationsDate->format('d/m/Y H:i');

        $endVotationsDate = new DateTime($concurs->end_votations_date);        
        $concurs->end_votations_date = $endVotationsDate->format('d/m/Y H:i');
        $winnerName = "";
        if($concurs->finished){
            $winner = $concurs->projects()->where('id',$concurs->id_winner)->first();
            $winnerName = $winner->project_name;
        }        
        return view('votacions.show')->with('concurs', $concurs)->with('winner',$winnerName);
    }

    public function showContest()
    {

    }

    private function _createPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}