@extends('layouts.master', ['body_class' => 'home colaborador'])
@section('content')

<div class="row" style="padding-top:20px">    
    <div class="col-12">
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