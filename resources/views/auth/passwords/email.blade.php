@extends('layouts.login')
@section('content')
<div class="container password">
    <div class="row">
        <div class="col-12 logo-login">
            <img class="img-fluid logo-ateneu" src="{{ asset('img/logo.png') }}" alt="logo" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Restaurar Contrasenya</div>
                <div class="card-body">
                    <div class="info">REBRAS UN CORREU ELECTRONIC PER CONFIGURAR LA TEVA CONTRASENYA D'ACCÉS A L'ÁREA DE SOCIS</div>
                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                        <div class="form-group row{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">DNI Soci/a</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 col-md-4 offset-md-4">
                                <button type="submit" class="btn btn-outline-success">Recuperar contrasenya
                                </button>
                            </div>
                            <div class="col-4">
                                <a class="btn btn-outline-secondary" href="{{ route('login') }}">
                                    Tornar
                                </a>
                            </div>
                        </div>
                    </form>
                    <div class="no-recived">SI NO REPS EL CORREU CONTACTA AMB <a href="mailto:socis@lalianca.cat">socis@lalianca.cat</a> INDICANT NOM, COGNOM, DNI I CORREU ELECTRONIC</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection