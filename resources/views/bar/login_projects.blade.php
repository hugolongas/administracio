@extends('layouts.login')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 logo-login">
            <img class="img-fluid logo-ateneu" src="{{ asset('img/logo.png') }}" alt="logo" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('projectBarAccess') }}">
                        {{ csrf_field() }}
                        <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contrasenya</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-5 col-md-3 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    Autenticar-se
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection