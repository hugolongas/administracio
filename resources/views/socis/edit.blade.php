@extends('layouts.master', ['body_class' => 'socis edit'])

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
@endpush
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
@stop

@section('content')
<div class="options-menu">
    <a href="{{ route('socis')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row" style="margin-top:40px ">
    <div class="col-md-12 ">
        <div>
            <h2>
                Editar Soci
            </h2>
            <div style="padding:30px">
                <form action="{{route('socis.update',$soci->id) }}" method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
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
                                    <div class="form-row">
                                        <div class="form-group col-4">
                                            <label for="name">Nom*:</label>
                                            <input type="text" name="name" id="name" class="form-control" tabindex="1"
                                                value="{{old('name', $soci->name)}}" />
                                            @if($errors->has('name'))
                                            <span class="error-message">Has d'indicar un nom</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="surname">Cognom*:</label>
                                            <input type="text" name="surname" id="surname" class="form-control"
                                                tabindex="2" value="{{old('surname', $soci->surname)}}" />
                                            @if($errors->has('surname'))
                                            <span class="error-message">Has d'indicar un Cognom</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="secondSurname">Segon Cognom*:</label>
                                            <input type="text" name="secondSurname" id="secondSurname"
                                                class="form-control" tabindex="3"
                                                value="{{old('secondSurname', $soci->second_surname)}}" />
                                            @if($errors->has('secondSurname'))
                                            <span class="error-message">Has d'indicar un segón Cognom</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-4">
                                            <label for="dni">DNI*:</label>
                                            <input type="text" name="dni" id="dni" class="form-control" tabindex="4"
                                                value="{{old('dni', $soci->dni)}}" />
                                            @if($errors->has('dni'))
                                            <span class="error-message">Has d'indicar un DNI</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="birthDate">Data de naixement*:</label>
                                            <input type="date" name="birthDate" id="birthDate" class="form-control"
                                                tabindex="5" value="{{old('birthDate', $soci->birth_date)}}" />
                                            @if($errors->has('birthDate'))
                                            <span class="error-message">Has d'indicar la data de naixement</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="sex">Sexe:</label>
                                            <select id="sex" name="sex" class="form-control" tabindex="6">
                                                <option value="Undefined" @if(old('sex', $soci->sex)=='Undefined')
                                                    selected @endif > </option>
                                                <option value="Dona" @if(old('sex', $soci->sex)=='Dona') selected @endif
                                                    >Dona</option>
                                                <option value="Home" @if(old('sex', $soci->sex)=='Home') selected @endif
                                                    >Home</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-4">
                                            <label for="email">E-mail:</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                tabindex="7" value="{{old('email', $soci->email)}}" />                                           
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="mobile">Telèfon mòbil:</label>
                                            <input type="text" name="mobile" id="mobile" class="form-control" tabindex="8"
                                                value="{{old('mobile', $soci->mobile)}}" />                                            
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="phone">Telèfon alternatiu:</label>
                                            <input type="text" name="phone" id="phone" class="form-control"
                                                tabindex="9" value="{{old('phone', $soci->phone)}}" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-4">
                                            <label for="tipusSoci">Tipus de Soci:</label>
                                            {{$soci->tipus_soci}}
                                            <select id="tipusSoci" name="tipusSoci" class="form-control" tabindex="10">
                                                @foreach($tipusSocis as $tSoci)
                                                <option value="{{$tSoci->tipus_soci}}" @if(old('tipusSoci', $soci->tipus_soci)==$tSoci->tipus_soci)
                                                        selected @endif >{{$tSoci->tipus_soci}} ({{$tSoci->cuota_soci}}€)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-4 ">
                                            <label for="cuotaSoci">Cuota Soci:</label>                                            
                                            <input id="cuotaSoci" name="cuotaSoci" class="form-control cuota_soci" tabindex="11" value="{{old("cuotaSoci"),$soci->cuota_soci}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <input type="hidden" id="imgChanged" name="imgChanged" value="false" />
                                    <input type="hidden" id="imgName" name="imgName"
                                        value="{{old('imgName', $soci->soci_img)}}" />
                                    <input type="hidden" id="prevImgName" name="prevImgName"
                                        value="{{old('prevImgName', $soci->soci_img)}}" />
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="cabinet center-block">
                                                    <figure>
                                                        <img class="gambar img-responsive img-thumbnail"
                                                            id="item-img-output"
                                                            src="{{asset('storage/socis').'/'.$soci->soci_img}}" />
                                                        <figcaption><i class="fas fa-camera"></i></figcaption>
                                                    </figure>
                                                    <input type="file" class="item-img file center-block"
                                                        name="file_photo" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 dades-observacions">
                            <h4>Observacions</h4>                            
                            <textarea id="observacions" name="observacions">{!!old('observacions'),$soci->observacions!!}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 dades-adresa">
                                <h4>Adreça</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-row">
                                        <div class="form-group col-2">
                                            <label for="road">Via:</label>
                                            <select id="road" name="road" class="form-control" tabindex="11">
                                                @foreach($roads as $road)
                                                <option value="{{$road->road}}" @if (old('road',$soci->
                                                    road)==$road->road) selected @endif
                                                    >{{$road->road}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-7">
                                            <label for="address">Adreça*:</label>
                                            <input type="text" name="address" id="address" class="form-control"
                                                list="addresses" tabindex="12"
                                                value="{{old('address',$soci->address)}}" />
                                            <datalist id="addresses">
                                                @foreach($addresses as $address)
                                                <option value="{{$address->address}}">
                                                    @endforeach
                                            </datalist>
                                            @if($errors->has('address'))
                                            <span class="error-message">Has d'indicar una adreça</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-1">
                                            <label for="addressNum">Número*:</label>
                                            <input type="text" name="addressNum" id="addressNum" class="form-control"
                                                tabindex="13" value="{{$soci->address_num}}" />
                                            @if($errors->has('addressNum'))
                                            <span class="error-message">Has d'indicar un número de pis</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-1">
                                            <label for="addressFloor">Pis:</label>
                                            <input type="text" name="addressFloor" id="addressFloor"
                                                class="form-control" tabindex="14" value="{{$soci->address_floor}}" />
                                        </div>
                                        <div class="form-group col-1">
                                            <label for="addressDoor">Porta:</label>
                                            <input type="text" name="addressDoor" id="addressDoor" class="form-control"
                                                tabindex="15" value="{{$soci->address_door}}" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-4">
                                            <label for="postalCode">Codi postal*:</label>
                                            <input type="text" name="postalCode" id="postalCode" class="form-control"
                                                tabindex="16" value="{{old('postalCode',$soci->postal_code)}}" />
                                                @if($errors->has('postalCode'))
                                            <span class="error-message">Has d'indicar un codi postal</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="city">Població*:</label>
                                            <input type="text" name="city" id="city" class="form-control" tabindex="17"
                                                value="{{old('city',$soci->city)}}" />
                                                @if($errors->has('city'))
                                            <span class="error-message">Has d'indicar una ciutat</span>
                                            @endif
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
                                    <div class="form-row">
                                        <div class="form-group col-4">
                                            <label for="accountHolder">Nom complert del Titular <i>(Si es diferent del
                                                Soci)</i>:</label>
                                            <input type="text" name="accountHolder" id="accountHolder"
                                                class="form-control" tabindex="18" value="{{old('accountHolder',$soci->account_holder)}}" />
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="dniHolder">Dni del Titular <i>(Si es diferent del
                                                    Soci)</i>:</label>
                                            <input type="text" name="dniHolder" id="dniHolder" class="form-control"
                                                tabindex="19" value="{{old('dniHolder',$soci->dni_holder)}}" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="iban">IBAN:</label>
                                            <input type="text" name="iban" id="iban" class="form-control" tabindex="20"
                                                value="{{old('iban',$soci->iban)}}" />
                                            <input type="hidden" name="correctIban" id="correctIban" value="false" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-outline-primary" style="padding:8px 100px;margin-top:25px;">
                            Actualitzar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Editar imatge de Soci</h4>
            </div>
            <div class="modal-body">
                <div id="upload-demo" class="center-block"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-default" data-dismiss="modal">Tancar</button>
                <button type="button" id="cropImageBtn" class="btn btn-outline-primary">Carregar</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
    // Start upload preview image
    var $uploadCrop,tempFilename,rawImg,imageId;
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
            rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
        swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
        width: 200,
        height: 200,
        },
        enforceBoundary: false,
        enableExif: true
    });
    
    $('#cropImagePop').on('shown.bs.modal', function(){
        $uploadCrop.croppie('bind', {
        url: rawImg
        }).then(function(){
            console.log('jQuery bind complete');
        });
    });

    $('.item-img').on('change', function () {
        imageId = $(this).data('id');
        tempFilename = $(this).val();
        $('#cancelCropBtn').data('id', imageId); readFile(this); 
    });

    $('#cropImageBtn').on('click', function (ev) {
        imgName = $("#imgName").val();
        $uploadCrop.croppie('result', {
        }).then(function (img) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('socis.uploadImage')}}",
                type: "POST",
                data: {"image":img,"imgName":imgName},
                success: function (resp) {
                    if(resp.status)
                    {
                        $('#item-img-output').attr('src',img);
                        $("#imgName").val(resp.imgName);
                        $("#imgChanged").val(true);
                        $('#cropImagePop').modal('hide');
                    }
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function(){
        var ok = fn_validate($("#iban").val());
        if(ok)
        {
            $("#iban").css("color","green");
            $("#correctIban").val(true);
        }
        else
        {
            $("#iban").css("color","red");
            $("#correctIban").val(false);
        }
    $("#iban").on('keyup',function(){
        var iban = this.value;
        var ok = fn_validate(iban);
        if(ok)
        {
            $("#iban").css("color","green");
            $("#correctIban").val(true);
        }
        else
        {
            $("#iban").css("color","red");
            $("#correctIban").val(false);
        }
    });
    var optionSelected = $("option:selected", $("#tipusSoci"));
    if(optionSelected[0].value=='Protector')
        {
            $(".cuota_soci").show();
        }
        else
        {
            $(".cuota_soci").hide();
        }
    

    $("#tipusSoci").on('change',function(){
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if(valueSelected=='Protector')
        {
            $(".cuota_soci").show();
        }
        else
        {
            $(".cuota_soci").hide();
        }
    });
});

    var fn_validate = function fn_ValidateIBAN(IBAN) {
        //Se pasa a Mayusculas
        IBAN = IBAN.toUpperCase();
        //Se quita los blancos de principio y final.
        IBAN = IBAN.trim();
        IBAN = IBAN.replace(/\s/g, ""); //Y se quita los espacios en blanco dentro de la cadena
        var letra1,letra2,num1,num2;
        var isbanaux;
        var numeroSustitucion;
        //La longitud debe ser siempre de 24 caracteres
        if (IBAN.length != 24) {
            return false;
        }
        // Se coge las primeras dos letras y se pasan a números
        letra1 = IBAN.substring(0, 1);
        letra2 = IBAN.substring(1, 2);
        num1 = getnumIBAN(letra1);
        num2 = getnumIBAN(letra2);
        //Se sustituye las letras por números.
        isbanaux = String(num1) + String(num2) + IBAN.substring(2);
        // Se mueve los 6 primeros caracteres al final de la cadena.
        isbanaux = isbanaux.substring(6) + isbanaux.substring(0,6);
        //Se calcula el resto, llamando a la función modulo97, definida más abajo
        resto = modulo97(isbanaux);
        if (resto == 1){
            return true;
        }else{
            return false;
        }
    }

    function modulo97(iban) {
        var parts = Math.ceil(iban.length/7);
        var remainer = "";

        for (var i = 1; i <= parts; i++) {
            remainer = String(parseFloat(remainer+iban.substr((i-1)*7, 7))%97);
        }
        return remainer;
    }

    function getnumIBAN(letra) {
        ls_letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return ls_letras.search(letra) + 10;
    }

</script>
@stop