@extends('layouts.master', ['body_class' => 'home junta'])
@section('content')

<div class="row" style="padding-top:20px">
    <div class="col-12 col-md-4 socis">
        <div class="card">
            <div class="card-header">Socis</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><div class="socis-total">Socis totals:{{$socis}}</div></li>
                    <li class="list-group-item"><div class="socis-actius">Socis actius:{{$socisActius}}</div></li>
                    <li class="list-group-item"><div class="socis-inactius">Socis baixa:{{$socisInactiu}}</div></li>
                </ul>                
            </div>
        </div>
    </div>
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header">Activitats</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($activities as $a)
                    <li>{{$a->name}}</li>
                    @endforeach
                </ul>                
            </div>
        </div>
    </div>
</div>
@if($isSoci)
<div class="row" style="padding-top:20px">
    <div class="col-12 col-md-4 actes">
        <div class="card">
            <div class="card-header">Últims Actes</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">                    
                </ul>                
            </div>
        </div>
    </div>
</div>
@endif
@endsection