<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            if(Auth::user()->checkRoles("junta"))
            {
                return $this->getJunta();
            }
            else if(Auth::user()->checkRoles("colaborador"))
            {
                return $this->getColaborador();
            }
            else if(Auth::user()->checkRoles("promotor"))
            {
                return $this->getPromotor();
            }
            else if(Auth::user()->checkRoles("soci")){
                return $this->getSoci();
            }


            return view('home');
        }
        else
        {
            return view('login');
        }
        
    }

    private function getSoci()
    {
        return view('sociHome');
    }

    private function getJunta()
    {
        $isSoci=false;
        if(Auth::user()->soci!=null)
        {
            $isSoci = true;
        }
        else{
            
        }
        $socis = Soci::all()->count();
        $socisActius = Soci::where('unregister_date',null)->get()->count();
        $socisInactius = Soci::where('unregister_date','<>',null)->get()->count();        
        return view('juntaHome')->with('socis',$socis)->with('socisActius',$socisActius)->with('socisInactiu',$socisInactius)->with('isSoci',$isSoci);
    }
    private function getColaborador()
    {
        $isSoci=false;
        if(Auth::user()->soci!=null)
        {
            $isSoci = true;
        }
        else{
            
        }        
        return view('colaboradorHome')->with('isSoci',$isSoci);
    }
}
