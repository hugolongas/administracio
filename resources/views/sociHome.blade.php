@extends('layouts.master', ['body_class' => 'home soci'])
@section('content')

<div class="row" style="padding-top:20px">
    <div class="col-12 col-md-4 actes">
        <div class="card">
            <div class="card-header">Últims Actes</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">      
                    @foreach ($actes as $a)
                        <li>{{$a->name}}</li>
                    @endforeach              
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
@endsection