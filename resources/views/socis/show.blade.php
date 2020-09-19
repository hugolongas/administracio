@extends('layouts.master', ['body_class' => 'socis show'])
@section('content')
<div class="options-menu">
        <a href="{{ route('socis')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<div class="row">
    <div class="col-12 dades">
        <div class="row">
            <div class="col-4">
                <span class="field">Num soci:</span>
                {{$soci->member_number}}
            </div>
            <div class="col-4">
                <span class="field">Data Alta:</span>
                {{$soci->register_date}}
            </div>
            <div class="col-4">
                <span class="field">Data Baixa:</span>
                {{$soci->unregister_date}}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 dades-personals">
        <h4>Dades Personals</h4>
        <div class="row">
            <div class="col-10">
                <div class="row">
                    <div class="col-4">
                        <span class="field">Nom:</span>
                        {{$soci->name}}
                    </div>
                    <div class="col-4">
                        <span class="field">Cognom:</span>
                        {{$soci->surname}}
                    </div>
                    <div class="col-4">
                        <span class="field">Segon Cognom:</span>
                        {{$soci->second_surname}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="field">DNI:</span>
                        {{$soci->dni}}
                    </div>
                    <div class="col-4">
                        <span class="field">Data de naixement:</span>
                        {{$soci->birth_date}}
                    </div>
                    <div class="col-4">
                        <span class="field">Sexe:</span>
                        {{$soci->sex}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="field">E-mail:</span>
                        {{$soci->email}}
                    </div>
                    <div class="col-4">
                        <span class="field">Telèfon mòbil:</span>
                        {{$soci->mobile}}
                    </div>
                    <div class="col-4">
                        <span class="field">Telèfon alternatiu:</span>
                        {{$soci->phone}}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <span class="field">Tipus de Soci:</span>
                        {{$soci->tipus_soci}}
                    </div>
                    <div class="form-group col-4 ">
                        <span class="field">Cuota Soci:</span>
                        {{$soci->cuota_soci}}
                    </div> 
                </div>
            </div>
            <div class="col-2">                    
                <div class="row">
                    <div class="col-xs-12">                                
                        <img src="{{asset('storage/socis').'/'.$soci->soci_img}}" class="img-fluid" id="soci_img" />
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
<div class="row">
    <div class="col-12 dades-observacions">
        <h4>Observacions</h4>
        {!!$soci->observacions!!}
    </div>
</div>
<div class="row">
    <div class="col-12 dades-adresa">
        <h4>Adreça</h4>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-2">
                        <span class="field">Via:</span>
                        {{$soci->road}}
                    </div>
                    <div class="col-7">
                        <span class="field">Adreça:</span>
                        {{$soci->address}}
                    </div>
                    <div class="col-1">
                        <span class="field">Número</span>
                        {{$soci->address_num}}
                    </div>
                    <div class="col-1">
                        <span class="field">Pis</span>
                        {{$soci->address_floor}}
                    </div>
                    <div class="col-1">
                        <span class="field">Porta</span>
                        {{$soci->address_door}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="field">Codi postal:</span>
                        {{$soci->postal_code}}
                    </div>
                    <div class="col-4">
                        <span class="field">Població:</span>
                        {{$soci->city}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 dades-banc">
        <h4>Dades Bancaries</h4>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-4">
                        <span class="field">Nom complert del Titular<i>(Si es diferent del Soci)</i>:<br/></span>
                        {{$soci->account_holder}}
                    </div>
                    <div class="col-4">
                        <span class="field">Dni del Titular<i>(Si es diferent del Soci)</i>:</span>
                        {{$soci->dni_holder}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="field">IBAN:</span>
                        {{$soci->iban}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop