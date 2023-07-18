<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Document extends Model
{
    public static function getUserDocuments(){
        $user = Auth::user();
        if($user->isAdmin()){
            return Document::orderBy('updated_at','desc')->get();
        }        
        else{
            $groupsIds = $user->groups->pluck('id')->toArray();
            $data =  Document::whereIn('group_id', $groupsIds)->orderBy('updated_at','desc')->get();;
            return $data;
        }

    }
}
