@extends('layouts.master', ['body_class' => 'users create'])

@push('scripts')
@endpush
@section('css')
<style>
    
</style>
@stop

@section('content')
<div class="options-menu">
    <a href="{{ route('users')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Crear Usuari</h2>
        <div style="padding:30px ">
            <form action="{{route('users.store') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-12 dades-personals">
                        <h4>Dades Usuari</h4>
                        <div class="row">
                            <div class="col-10">
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="name">Nom*:</label>
                                        <input type="text" name="name" id="name" class="form-control" tabindex="1"
                                            value="{{ old('name') }}" />
                                        @if($errors->has('name'))
                                        <span class="error-message">Has d'indicar un nóm</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">Email*:</label>
                                        <input type="mail" name="email" id="email" class="form-control" tabindex="2"
                                            value="{{ old('email') }}" />
                                        @if($errors->has('email'))
                                        <span class="error-message">Has d'indicar un email</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="username">Nom d'usuari*:</label>
                                        <input type="text" name="username" id="username" class="form-control"
                                            tabindex="3" value="{{ old('username') }}" />
                                        @if($errors->has('username'))
                                        <span class="error-message">Has d'indicar un nom d'usuari</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="password">Contrasenya*:</label>
                                        <input type="text" name="password" id="password" class="form-control"
                                            tabindex="3" value="{{ old('password') }}" />
                                        @if($errors->has('password'))
                                        <span class="error-message">Has d'indicar una contrasenya</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center ">
                    <button type="submit " class="btn btn-outline-primary " style="padding:8px 100px;margin-top:25px; ">
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
@stop