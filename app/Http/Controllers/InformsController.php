<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Soci;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomExport;
use PDF;

class InformsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('informs.index');
    }

    public function llistaSocis(){
        $socis = Soci::whereNull('unregister_date')->orderBy('surname')->get();
        $pdf = PDF::loadView('informs.llistaSocis',['socis'=>$socis]);
        return $pdf->download('llistaSocis.pdf');
    }

    public function llistaSocisMenorscatorze()
    {
        $AnyMenors = 14;
        $mesMenors = date('m');
        $actualDate = date('Y-m-d');
        $stringRaw = 'floor(datediff("'.$actualDate.'",birth_date)/365) as edat';
        $socis =  DB::table('socis')
        ->select('member_number','name','surname','second_surname','birth_date')
        ->selectRaw($stringRaw)
        ->whereNull('unregister_date')
        ->whereRaw('(YEAR(now())-YEAR(birth_date))<=14')        
        ->orderBy('surname')
        ->get();
        $headings = array('nº Soci','nom','cognom','segon cognom','data naixement','edat');
        return Excel::download(new CustomExport($socis->all(),$headings), 'socis.xlsx');
    }

    public function customExport($idList)
	{
        $llista = CustomExport::findOrfail($idList);		
        $selectFields = explode(',',$llista->fields);
        $headings = explode(',',$llista->headings);
		$socis = Soci::all($selectFields);		
		return Excel::download(new CustomExport($socis->all(),$headings), 'socis.xlsx');
	}
}
