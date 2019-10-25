@extends('layouts.master', ['body_class' => 'informes'])
@section('css')
@stop
@section('js')

@stop

@section('content')
<h2>Informes</h2>
<div class="row">
    <div class="col-12 col-sm-4">
        <h4>Llistat socis per activitats</h4>
        <a type="button" class="btn btn-outline-dark" href="{{ route('informs.llistaSocis')}}">Crear Informe</a>
    </div>
    <div class="col-12 col-sm-4">
        <h4>Llistat socis menors de 14 anys</h4>
        <a type="button" class="btn btn-outline-dark" href="{{ route('informs.socisMenors')}}">Crear Informe</a>
    </div>
</div>
@stop
@push('scripts')

@endpush