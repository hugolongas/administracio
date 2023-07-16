<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Document extends Model
{
    public static function getUserDocuments(){
        $user = Auth::user();
        if($user->isAdmin()){
            return Document::all();
        }        
        else{
            $sectionIds = $user->sections->pluck('id')->toArray();
            $data =  Document::whereIn('section_id', $sectionIds)->get();
            return $data;
        }

    }
}
