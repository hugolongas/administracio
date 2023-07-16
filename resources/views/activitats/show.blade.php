@extends('layouts.master', ['body_class' => 'activitats show'])
@section('content')
<div class="options-menu">
    <a href="{{ route('activitats')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<h4>Dades Activitat</h4>
<div class="row" style="margin-top:40px ">
    <div class="col-4">            
        Creat per: {{$activity->created_by}}
    </div>
    <div class="col-4">
        Nom*: {{$activity->created_by}}
    </div>
    <div class="col-4">
        Data de l'activitat*:{{$activity->activity_date}}
    </div>
    <div class="col-12 dades-description">
        <h4>Descripció</h4>
        {{$activity->description}}
    </div>
</div>
@stop