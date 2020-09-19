@extends('layouts.master', ['body_class' => 'votacions votar'])

@section('css')
<style>
    #votation-form {
        max-width: 700px;
        margin: 0px auto;
        text-align: center;
    }
    .radios{
        margin-bottom:15px;
    }

    .radios .radio {
        background-color: #fff;
        display: inline-block;
        cursor: pointer;
        border: 1px solid #8C8C8C;
        padding: 10px;
        width: 130px;
        height: 130px;
        text-align: center;
        padding-top: 45px;
    }

    @media only screen and (min-width:768px) {
        .radios .radio {
            padding-top: 45px;
            width: 130px;
            height: 130px;
        }
    }

    .radios input[type=radio] {
        display: none;
    }

    .radios input[type=radio]:checked+.radio {
        background-color: #b7b7b7;
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
    <form id="votacio-form" action="{{route('votacions.store') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="idConcurs" id="idConcurs" class="form-control" tabindex="1"
            value="{{$concurs->id}}" />
        @if($concurs->projects->count()>0)
        @php
        $elementsPerRow = 2;
        $colSize = 6;
        $totalProjects = $concurs->projects->count();
        if($totalProjects>2){
        $elementsPerRow = 3;
        $colSize = 4;
        }
        @endphp
        @foreach($concurs->projects->chunk($elementsPerRow) as $projects)
        @php $elements = 0 @endphp
        <div class="row radios">
            @foreach($projects as $project)
            <div class="col-{{$colSize}} d-flex justify-content-center">
                <div>
                    <input type="radio" name="project_vote" value="{{$project->id}}" id="r{{$project->id}}" />
                    <label class="radio" for="r{{$project->id}}">
                        <div class="project-info">
                            {{$project->project_name}}
                        </div>
                    </label>
                    <div>
                        <a href="{{asset('storage/').$project->project_url}}" class="btn btn-outline-info"
                            target="_blank">
                            Veure Projecte
                        </a>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
        @endforeach
        @endif        
        <div class="form-group text-center ">            
            <input type="submit" class="btn btn-outline-success" style="padding:8px 100px;margin-top:25px;"
                value="Votar" tabindex="9" />
            @if($errors->has('project_vote'))
            <div>
                <span class="error-message">Has de seleccionar un projecte</span>
            </div>
            @endif
        </div>
    </form>
</div>
</div>
@stop


@section('js')
<script>
    $(document).ready(function(){
    $('#votacio-form').submit(function() {
    var status = confirm("Segur que vols votar per aquest projecte");
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