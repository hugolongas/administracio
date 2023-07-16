<?php

namespace App\Http\Controllers;

use App\Document;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

use Illuminate\Support\Str;

use Notification;
use Validator;
use Redirect;
use Storage;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Document::getUserDocuments();
        return view('documents.index')->with("documents",$data);
    }

    public function indexJunta(Request $request){
        if ($request->ajax()) {
            $data = Document::orderBy('updated_at','desc')->get();

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
                })->addColumn('section',function($row){
                    $section = Section::findOrFail($row->section_id);
                    return $section->section_name;
                })
                ->rawColumns(['view', 'edit', 'delete'])->make(true);
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
        $sections = Section::all();
        return view('documents.create')->with("sections",$sections);
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
            'file'=>'required|max:50000|mimes:doc,docx,pdf'            
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
        $sectionId = $request->input('section');
        $file_name= "";
        $type ="";
        $fileSize = 0;
        if ($request->hasfile('file')) {
            $path = "documents/";
            if(!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path, 0775, true); //creates directory
            }
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            $fileName = Str::random(8) . date('Ymdhm');
            $file_name = $fileName . '.'.$extension;
            $type= $this->_GetFileType($extension);
            $projectUrl = $path . $file_name;
            Storage::disk('public')->put($projectUrl,file_get_contents($file));
        }
        $document = new Document;        
        $document->section_id=$sectionId;
        $document->title=$title;
        $document->summary=$summary;
        $document->file_name = $file_name;
        $document->size = $fileSize;
        $document->type = $type;
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
        $sections = Section::all();
        return view('documents.edit')->with("sections",$sections)->with("document",$document);
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
        $sectionId = $request->input('section');
        
        $type ="";
        $fileSize = 0;
        if ($request->hasfile('file')) {
            $path = "documents/";
            if(!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path, 0775, true); //creates directory
            }
            //Eliminamos el antiguo
            $fileUrl = $path . $file_name;
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

            $fileUrl = $path . $file_name;            
            Storage::disk('public')->put($fileUrl,file_get_contents($file));
        }
        $document->section_id=$sectionId;
        $document->title=$title;
        $document->summary=$summary;        
        $document->save();
        
        Notification::success("S'ha actualitzat el document");
        return redirect()->route('documentsAdmin');
    }

    public function delete($id)
    {
        $document = Document::findOrFail($id);
        $path = "documents/";
        $fileUrl = $path . $document->file_name;
        Storage::disk('public')->delete($fileUrl);
        $document->delete();
    }

    private function _GetFileType($extension){        
        switch($extension)
        {
            case "doc":
            case "docx":
            {
                return "word";
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
                case "pdf":
                    {
                        return "pdf";
                    }
        }

    }
}