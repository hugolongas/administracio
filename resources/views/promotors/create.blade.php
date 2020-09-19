@extends('layouts.master', ['body_class' => 'promotors crear'])
@section('content')
<div class="options-menu">
    <a href="{{ url()->previous() }}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row" style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2> Crear Promotor</h2>
        <div style="padding:30px ">
            <form action="{{ action('PromotorController@store') }}" method="post">
                {{ csrf_field() }}
                <div class="row ">
                    <div class="col-12 ">
                        <div class="form-group">
                            <label for="promotor_name ">Nom Promotor</label>
                            <input type="text" name="promotor_name" id="promotor_name" class="form-control ">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="promotor_desc">Descripció:</label>
                            <textarea name="promotor_desc" id="promotor_desc" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <fieldset>
                        <legend>Usuari promotor</legend>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="user_name">Nom d'usuari(No ha de contenir accents)</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="user_email">Email de contacte</label>
                                <input type="text" name="user_email" id="user_email" class="form-control" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="user_password">Contraseña d'usuari</label>
                                <input type="text" name="user_password" id="user_password" class="form-control" />
                            </div>

                        </div>
                    </fieldset>
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