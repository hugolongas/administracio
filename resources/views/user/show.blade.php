@extends('layouts.master', ['body_class' => 'users show'])

@push('scripts')
@endpush
@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="options-menu">
        <a href="{{ route('users') }}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
    </div>
    <div class=" row " style="margin-top:40px ">
        <div class="col-md-12 ">
            <h2>Usuari: {{ $user->username }}</h2>            
            <div style="padding:30px ">
                <div class="row">
                    <div class="col-12 dades-personals">
                        <h4>Dades Usuari</h4>
                        <div class="row">
                            <div class="col-10">
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="name">Nom:</label>
                                        {{$user->name }}
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">Email*:</label>
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
@stop
