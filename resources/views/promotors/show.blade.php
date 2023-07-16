@extends('layouts.master', ['body_class' => 'promotor show'])
@section('content')
<div class="options-menu">
    <a href="{{ url()->previous() }}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>
                {{$promotor->promotor_name}}
        </h2>
        <div class="description">
        {{$promotor->description}}
        </div>
    </div>
</div>
@stop