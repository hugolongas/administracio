<?php

namespace App\Http\Controllers;

use App\Document;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use Notification;
use Validator;
use Redirect;
use Storage;

class DocumentsController extends Controller
{

    private $DocumentPath = "documents/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        
    }

    public function index()
    {
        $data = Document::getUserDocuments();
        return view('documents.index')->with("documents",$data);
    }

    public function indexJunta(Request $request){
        if ($request->ajax()) {
            $data = Document::getUserDocuments();

            return Datatables::of($data)
                ->addColumn('edit', function ($row) {
                    $url = route('documentsAdmin.edit', ['document'=>$row]);
                    $btn = '<a href="' . $url . '" class="edit btn btn-outline-primary">Editar</a>';
                    if($row->finished)
                    $btn = '<button class="edit btn btn-outline-primary" disabled>Editar</button>';
                    return $btn;
                })->addColumn('view', function ($row) {
                    $url = route('documents.show', ['document'=>$row]);
                    $btn = '<a href="' . $url . '" class="view btn btn-outline-primary">Veure</a>';                    
                    return $btn;
                })->addColumn('delete',function(){
                    $btn = '<button class="btn btn-outline-danger" accion="delete">Eliminar</button>';                    
                    return $btn;
                })->addColumn('group',function($row){
                    $group = Group::findOrFail($row->group_id);
                    return $group->name;
                })
                ->addColumn('download',function($row){
                    $url = route('documents.download', ['document'=>$row]);
                    $link = '<a href="'.$url.'" class="view btn btn-outline-primary">Descarregar</a>';
                    return $link;
                })
                ->rawColumns(['view', 'edit','download', 'delete'])->make(true);
        }
        return view('documents.indexJunta');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $groups = $user->groups;
        if($user->isAdmin()){
            $groups = Group::all();
        }
        return view('documents.create')->with("groups",$groups);
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
            'file'=>'required|max:50000|mimes:doc,docx,pdf,xlsx,xls,jpg,png,ppt,pptx'            
        ]);
        
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }
        $title = $request->input('name');
        $summary = $request->input('summary');
        if($summary==null){
            $summary = "";
        }
        $groupId = $request->input('group');
        $file_name= "";
        $type ="";
        $fileSize = 0;
        if ($request->hasfile('file')) {            
            if(!Storage::disk('public')->exists($this->DocumentPath)) {
                Storage::disk('public')->makeDirectory($this->DocumentPath, 0775, true); //creates directory
            }
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            $fileName = Str::random(8) . date('Ymdhm');
            $file_name = $fileName . '.'.$extension;
            $type= $this->_GetFileType($extension);
            $projectUrl = $this->DocumentPath . $file_name;
            Storage::disk('public')->put($projectUrl,file_get_contents($file));
        }
        $document = new Document;        
        $document->group_id=$groupId;
        $document->title=$title;
        $document->summary=$summary;
        $document->file_name = $file_name;
        $document->size = $fileSize;
        $document->type = $type;
        $document->extension=$extension;   
        $document->save();
        
        Notification::success("S'ha creat un nou document");
        return redirect()->route('documentsAdmin');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        if($document->type=="pdf")
        {
            return view("documents.pdf")->with("document",$document);
        }
        if($document->type="imatge")
        {
            return view("documents.imatge")->with("document",$document);
        }
        else{
            return view("documents.office")->with("document",$document);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        $groups = Group::all();
        return view('documents.edit')->with("groups",$groups)->with("document",$document);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',            
            'file'=>'max:50000|mimes:doc,docx,pdf'            
        ]);
        
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }
        $title = $request->input('name');
        $summary = $request->input('summary');
        $file_name= $request->input('old_fileName');
        if($summary==null){
            $summary = "";
        }
        $groupId = $request->input('group');
        
        $type ="";
        $fileSize = 0;
        if ($request->hasfile('file')) {            
            if(!Storage::disk('public')->exists($this->DocumentPath)) {
                Storage::disk('public')->makeDirectory($this->DocumentPath, 0775, true); //creates directory
            }
            //Eliminamos el antiguo
            $fileUrl = $this->DocumentPath . $file_name;
            Storage::disk('public')->delete($fileUrl);
            //Creamos el nuevo
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            $document->size = $fileSize;

            $fileName = Str::random(8) . date('Ymdhm');
            $file_name = $fileName . '.'.$extension;
            $document->file_name = $file_name;

            $type= $this->_GetFileType($extension);
            $document->type = $type;

            $fileUrl = $this->DocumentPath . $file_name;            
            Storage::disk('public')->put($fileUrl,file_get_contents($file));
        }
        $document->group_id=$groupId;
        $document->title=$title;
        $document->summary=$summary;        
        $document->extension=$extension;   
        $document->save();
        
        Notification::success("S'ha actualitzat el document");
        return redirect()->route('documentsAdmin');
    }

    public function delete($id)
    {
        $document = Document::findOrFail($id);        
        $fileUrl = $this->DocumentPath . $document->file_name;
        Storage::disk('public')->delete($fileUrl);
        $document->delete();
    }

    public function download(Document $document)
    {
        $fileUrl = $this->DocumentPath . $document->file_name;
        $fileName = $this->_removeAccents($document->title). '.'.$document->extension;
        return Storage::disk('public')->download($fileUrl,$fileName);
    }

    private function _GetFileType($extension){        
        switch($extension)
        {
            case "doc":
            case "docx":
            {
                return "word";
            }
            case "pdf":
            {
                return "pdf";
            }
            case "xls":
            case "xlsx":
            {
                return "excel";
            }                
            case "ppt":
            case "pptx":
            {
                return "powerpoint";
            }
            case "jpg":
            case "png":
            {
                return "imatge";
            }
        }
    }


    private function _removeAccents($string) {
        if ( !preg_match('/[\x80-\xff]/', $string) )
            return $string;
    
        $chars = array(
        // Decompositions for Latin-1 Supplement
        chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
        chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
        chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
        chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
        chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
        chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
        chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
        chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
        chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
        chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
        chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
        chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
        chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
        chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
        chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
        chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
        chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
        chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
        chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
        chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
        chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
        chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
        chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
        chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
        chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
        chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
        chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
        chr(195).chr(191) => 'y',
        // Decompositions for Latin Extended-A
        chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
        chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
        chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
        chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
        chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
        chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
        chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
        chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
        chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
        chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
        chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
        chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
        chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
        chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
        chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
        chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
        chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
        chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
        chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
        chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
        chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
        chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
        chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
        chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
        chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
        chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
        chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
        chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
        chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
        chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
        chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
        chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
        chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
        chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
        chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
        chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
        chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
        chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
        chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
        chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
        chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
        chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
        chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
        chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
        chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
        chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
        chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
        chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
        chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
        chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
        chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
        chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
        chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
        chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
        chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
        chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
        chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
        chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
        chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
        chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
        chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
        chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
        chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
        chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
        );
    
        $string = strtr($string, $chars);
    
        return $string;
    }
}