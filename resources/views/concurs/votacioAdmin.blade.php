@extends('layouts.master', ['body_class' => 'votacions votar'])

@section('css')
<style>
    #votation-form {
        max-width: 320px;
        margin: 0px auto;
        text-align: center;
    }
</style>
@stop
@push('scripts')
@endpush

@section('content')
<div class="options-menu">
    <a href="{{ route('votacions')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row" style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Votacions de projectes</h2>
    </div>
</div>
<div id="votation-form">
    <h3>{{$concurs->name}}</h3>
    <p>{!!$concurs->description!!}</p>
    <form action="{{route('votacions.storeAdmin') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="idConcurs" id="idConcurs" class="form-control" tabindex="1"
            value="{{$concurs->id}}" />
        <div class="form-group">
            <label for="name">DNI Soci*:</label>
            <input type="text" name="dni" id="dni" class="form-control" tabindex="1" value="{{ old('dni') }}" />
            @if($errors->has('dni'))
            <span class="error-message">Has d'indicar un dni</span>
            @endif
            @if($errors->has('dni_incorrecte'))
            <span class="error-message">El dni no pertany a cap soci</span>
            @endif
        </div>
        @if($concurs->projects->count()>0)
        <div class="form-group">
            <label for="project_vote">Projectes</label>
            <select class="form-control" id="project_vote" name="project_vote">
                <option value="" selected>Seleccionar...</option>
                @foreach($concurs->projects as $project)
                <option value="{{$project->id}}">{{$project->project_name}}</option>
                @endforeach
            </select>
            @if($errors->has('project_vote'))
            <span class="error-message">Has de seleccionar un projecte</span>
            @endif
                </div>
        @endif
        <div class="form-group text-center ">
            <input type="submit" class="btn btn-outline-success" style="padding:8px 100px;margin-top:25px;"
            value="Votar" tabindex="9" />
        </div>
    </form>
</div>
</div>
@stop


@section('js')
<script>
    $(document).ready(function(){
    $('#votacio-form').submit(function() {
    var status = confirm("Click OK to continue?");
    if(status == false){
    return false;
    }
    else{
    return true; 
    }
   });
});
</script>
@stop