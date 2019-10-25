@extends('layouts.master', ['body_class' => 'socis show'])

@push('scripts')
@endpush
@section('css')
@stop

@section('content')
<div class="options-menu">
    <a href="{{route("profile.edit") }}" class="btn btn-outline-dark"><i class="fas fa-edit"></i>   Editar</a>
</div>
<div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-4">
                    Num soci: {{$soci->member_number}}
                </div>
                <div class="col-4">
                    Data Alta: {{$soci->register_date}}
                </div>
                <div class="col-4">
                    Data Baixa: {{$soci->unregister_date}}
                </div>
            </div>
        </div>
        <hr/>
        <div class="col-12">
            <h3>Dades Personals</h3>
            <div class="row">
                <div class="col-10">
                    <div class="row">
                        <div class="col-4">
                            <label for="name">Nom:</label>
                            {{$soci->name}}
                        </div>
                        <div class="col-4">
                            <label for="surname">Cognom:</label>
                            {{$soci->surname}}
                        </div>
                        <div class="col-4">
                            <label for="secondSurname">Segon Cognom:</label>
                            {{$soci->second_surname}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="dni">DNI:</label>
                            {{$soci->dni}}
                        </div>
                        <div class="col-4">
                            <label for="birthDate">Data de naixement:</label>
                            {{$soci->birth_date}}
                        </div>
                        <div class="col-4">
                            <label for="sex">Sexe:</label>
                            {{$soci->sex}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">E-mail:</label>
                            {{$soci->email}}
                        </div>
                        <div class="col-4">
                            <label for="mobile">Téfon móvil:</label>
                            {{$soci->mobile}}
                        </div>
                        <div class="col-4">
                            <label for="phone">teléfon fixe:</label>
                            {{$soci->phone}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="sociProtector">Soci protector:</label>
                            {{$soci->soci_protector}}
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
        <hr/>
        <div class="col-12">
            <h3>Adreça</h3>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-2">
                            <label for="road">Via:</label>
                            {{$soci->road}}
                        </div>
                        <div class="col-7">
                            <label for="address">Adreça:</label>
                            {{$soci->address}}
                        </div>
                        <div class="col-1">
                            <label for="addressNum">Número</label>
                            {{$soci->address_num}}
                        </div>
                        <div class="col-1">
                            <label for="addressFloor">Pis</label>
                            {{$soci->address_floor}}
                        </div>
                        <div class="col-1">
                            <label for="addressDoor">Porta</label>
                            {{$soci->address_door}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="postalCode">Codi postal:</label>
                            {{$soci->postal_code}}
                        </div>
                        <div class="col-4">
                            <label for="city">Població:</label>
                            {{$soci->city}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="col-12">
            <h3>Dades Bancaries</h3>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <label for="accountHolder">Nom complert del Titular:</label>
                                {{$soci->account_holder}}
                        </div>
                        <div class="col-4">
                            <label for="dniHolder">Dni del Titular:</label>
                            {{$soci->dni_holder}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="iban">IBAN:</label>
                            {{$soci->iban}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@stop

@section('js')
@stop