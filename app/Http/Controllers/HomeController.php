<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Soci;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHome()
    {
        if (Auth::check()) {
            if (Auth::user()->checkRoles("junta"))
                return $this->_getJunta();
            if (Auth::user()->checkRoles("colaborador"))
                return $this->_getColaborador();
            if (Auth::user()->checkRoles("soci"))
                return $this->_getSoci();

            return view('home');
        } else {
            return view('login');
        }
    }

    private function _getSoci()
    {
        $activities = $this->_getActivities();
        $actes = $this->_getActes();
        return view('sociHome')
        ->with('actes', $actes)
            ->with('activities', $activities);
    }

    private function _getJunta()
    {
        $isSoci = false;
        if (Auth::user()->soci != null)
            $isSoci = true;
        $activities = $this->_getActivities();
        $socis = Soci::all();
        $socisCount = $socis->count();
        $socisActiusCount = $socis->where('unregister_date', null)->count();        
        $socisInactiusCount = $socis->where('unregister_date', '<>', null)->count();
        $socisPaga = $this->_getSocisCuota();
        $socisPagaCount = $socisPaga->count();
        

        return view('juntaHome')
            ->with('socis', $socisCount)
            ->with('socisPaga', $socisPagaCount)
            ->with('socisActius', $socisActiusCount)
            ->with('socisInactiu', $socisInactiusCount)
            ->with('isSoci', $isSoci)
            ->with('activities', $activities);
    }

    private function _getSocisCuota()
    {
        $socisresult =  DB::table('socis')->whereNull('unregister_date')
        ->whereRaw('(YEAR(NOW())-YEAR(birth_date))>=14 AND (YEAR(NOW())-YEAR(birth_date))<=69')
        ->get();
        return $socisresult;
    }

    private function _getColaborador()
    {
        $activities = $this->_getActivities();
        if (Auth::user()->soci != null){            
        $actes = $this->_getActes();
        return view('sociHome')
        ->with('actes', $actes)
            ->with('activities', $activities);
        }
        return view('colaboradorHome')            
            ->with('activities', $activities);
    }

    private function _getActivities()
    {
        $controller = new ActivitatsController();
        return $controller->getActivities();
    }

    
    private function _getActes()
    {
        $activitats = Auth::user()->soci->activitats();
        return $activitats->get();
    }
}
