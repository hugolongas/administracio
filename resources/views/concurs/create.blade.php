@extends('layouts.master', ['body_class' => 'concurs create'])

@section('css')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js">
</script>
@endpush

@section('content')
<div class="options-menu">
    <a href="{{ route('concurs')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Crear Concurs</h2>
        <div style="padding:30px ">
            <form action="{{route('concurs.store') }}" method="post">
                {{ csrf_field() }}
                <div class="concurs-dades">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="name">Nom Concurs*:</label>
                            <input type="text" name="name" id="name" class="form-control" tabindex="1"
                                value="{{ old('name') }}" />
                            @if($errors->has('name'))
                            <span class="error-message">Has d'indicar un nom per el concurs</span>
                            @endif
                        </div>
                        <div class="form-group col-6">
                            <label for="password_contest">Contrasenya (introdueix la contrasenya o deixa-ho buit perque es
                                generi automàticament):</label>
                            <div class="input-group">
                                <input type="password" name="password_contest" id="password_contest" class="form-control pwd"
                                    tabindex="2" value="{{old('password_contest')}}" placeholder="Contrasenya"
                                    aria-label="Password" />
                                <div class="input-group-append reveal">
                                    <span class="input-group-text">
                                        <i id="eye-icon" class="fas fa-eye-slash" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripció</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            tabindex="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label for="startVotationsDate">Inici Concurs (votacions)*:</label>
                            <div class="input-group date" id="startVotationsDate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="startVotationsDate"
                                    data-target="#startVotationsDate" value="{{ old('startVotationsDate') }}"
                                    tabindex="4" />
                                <div class="input-group-append" data-target="#startVotationsDate"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                </div>
                            </div>
                            @if($errors->has('startVotationsDate'))
                            <span class="error-message">Has d'indicar una data d'inici per el concurs</span>
                            @endif
                        </div>
                        <div class="form-group col-3">
                            <label for="endVotationsDate">Final Concurs (votacions)*:</label>
                            <div class="input-group date" id="endVotationsDate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="endVotationsDate"
                                    data-target="#endVotationsDate" value="{{ old('endVotationsDate') }}"
                                    tabindex="5" />
                                <div class="input-group-append" data-target="#endVotationsDate"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                </div>
                            </div>
                            @if($errors->has('endVotationsDate'))
                            <span class="error-message">Has d'indicar una data d'inici per el concurs</span>
                            @endif
                        </div>
                        <div class="form-group col-6">
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="mesaPercent">Punts Mesa*:</label>
                                    <input type="number" name="puntsMesa" id="puntsMesa" class="form-control"
                                        tabindex="7" value="{{old('puntsMesa', 50)}}" />
                                </div>
                                <div class="form-group col-4">
                                    <label for="mesaPercent">Percentatge Mesa*:</label>
                                    <input type="number" name="mesaPercent" id="mesaPercent" class="form-control"
                                        tabindex="8" value="{{old('mesaPercent', 50)}}" min="0" max="100" />
                                        @if($errors->has('mesaPercent'))
                                        <span class="error-message">El valor ha d'estar entre 0 i 100</span>
                                        @endif
                                </div>
                                <div class="form-group col-4">
                                    <label for="sociPercent">Percentatge Soci*:</label>
                                    <input type="number" name="sociPercent" id="sociPercent" class="form-control"
                                        tabindex="9" value="{{old('sociPercent', 50)}}" min="0" max="100" />
                                        @if($errors->has('sociPercent'))
                                        <span class="error-message">El valor ha d'estar entre 0 i 100</span>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center ">
                    <input type="submit" name="crear" class="btn btn-outline-primary" style="padding:8px 100px;margin-top:25px;"
                        value="Crear i tancar" tabindex="8" />
                    <input type="submit" name="crear_continuar" class="btn btn-outline-primary"
                        style="padding:8px 100px;margin-top:25px;" value="Crear i continuar" tabindex="9" />
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function(){     
    
    $(".reveal").on('click',function() {
        var $pwd = $(".pwd");
        if ($pwd.attr('type') === 'password') {
            $pwd.attr('type', 'text');
            $("#eye-icon").removeClass("fa-eye-slash");
            $("#eye-icon").addClass("fa-eye");
        } else {
            $pwd.attr('type', 'password');
            $("#eye-icon").removeClass("fa-eye");
            $("#eye-icon").addClass("fa-eye-slash");
        }
    });
        
    $("#mesaPercent").on('focusout',function(){
        var mesaPercent = this.value;
        var sociPercent = 100-mesaPercent;
        $("#sociPercent").val(sociPercent);
    });
    $("#sociPercent").on('focusout',function(){
        var sociPercent = this.value;
        var mesaPercent = 100-sociPercent;
        $("#mesaPercent").val(mesaPercent);
    });       
    $('#startVotationsDate').datetimepicker({
        locale: 'ca'
    });
    $('#endVotationsDate').datetimepicker({
        locale: 'ca',
        useCurrent: false
    });
    $("#startVotationsDate").on("change.datetimepicker", function (e) {
        $('#endVotationsDate').datetimepicker('minDate', e.date);
    });
    $("#endVotationsDate").on("change.datetimepicker", function (e) {
        $('#startVotationsDate').datetimepicker('maxDate', e.date);
    });
});
</script>
@stop