@extends('layouts.master', ['body_class' => 'section show'])
@section('content')
<div class="options-menu">
    <a href="{{ url()->previous() }}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>
                {{$group->name}}
        </h2>
        <div class="description">
        {{$group->description}}
        </div>
        <div class="num socis">
            Membres del grup: {{count($group->users)}}
            <div class="col-12">
                @foreach($group->users as $user)   
                @if($user->username!='administracio')                       
                <div class="badge badge-secondary">                            
                    {{$user->name}}                            
                    <i class="far fa-times-circle delete-user" data-id="{{$user->id}}"></i>
                </div>     
                @endif                   
                @endforeach
                </div>
        </div>
    </div>
</div>
@stop