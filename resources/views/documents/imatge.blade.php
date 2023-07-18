@extends('layouts.master', ['body_class' => 'documents crear'])
@section('content')
<div class="options-menu">

    <a href="{{ url()->previous() }}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Veure Document</h2>
        <div style="padding:30px ">
            <img src="{{asset('storage/documents/'.$document->file_name)}}" style="width: 100%"/>
        </div>
        @stop