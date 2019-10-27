@extends('layouts.master', ['body_class' => 'home colaborador'])
@section('content')

<div class="row" style="padding-top:20px">    
    <div class="col-12">
        <div class="card">
            <div class="card-header">Activitats</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
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