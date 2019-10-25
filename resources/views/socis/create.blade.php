@extends('layouts.master', ['body_class' => 'socis create'])

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
@endpush
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
<style>
    label.cabinet {
        display: block;
        cursor: pointer;
    }

    label.cabinet input.file {
        position: relative;
        height: 100%;
        width: auto;
        opacity: 0;
        -moz-opacity: 0;
        filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);
        margin-top: -30px;
        display: none;
    }

    #upload-demo {
        width: 250px;
        height: 250px;
        padding-bottom: 25px;
    }

    figure figcaption {
        position: absolute;
        bottom: 18px;
        color: #fff;
        padding-left: 5px;
        padding-bottom: 5px;
        text-shadow: 0 0 10px #000;
        left: 20px;
    }

    .error-message {
        color: #bd2417;
    }
</style>
@stop

@section('content')
<div class="options-menu">
    <a href="{{ route('socis')}}" class="btn btn-outline-dark"><i class="fa fa-angle-left"></i>tornar</a>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Crear Soci</h2>
        <div style="padding:30px ">
            <form action="{{route('socis.store') }}" method="post">
                {{ csrf_field() }}
                <div class="row ">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                Num soci:
                            </div>
                            <div class="col-4">
                                Data Alta: {{ date('d-m-Y') }}
                            </div>
                            <div class="col-4">
                                Data Baixa:
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        Dades Personals
                        <div class="row">
                            <div class="col-10">
                                <div class="form-row">
                                    <div class="form-group col-4">
                                        <label for="name">Nom*:</label>
                                        <input type="text" name="name" id="name" class="form-control" tabindex="1"
                                            value="{{ old('name') }}" />
                                        @if($errors->has('name'))
                                        <span class="error-message">Has d'indicar un nóm</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="surname">Cognom*:</label>
                                        <input type="text" name="surname" id="surname" class="form-control" tabindex="2"
                                            value="{{ old('surname') }}" />
                                        @if($errors->has('surname'))
                                        <span class="error-message">Has d'indicar un Cognom</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="secondSurname">Segon Cognom*:</label>
                                        <input type="text" name="secondSurname" id="secondSurname" class="form-control"
                                            tabindex="3" value="{{ old('secondSurname') }}" />
                                        @if($errors->has('secondSurname'))
                                        <span class="error-message">Has d'indicar un segon cognom</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-4">
                                        <label for="dni">DNI*:</label>
                                        <input type="text" name="dni" id="dni" class="form-control" tabindex="4"
                                            value="{{ old('dni') }}" />
                                        @if($errors->has('dni'))
                                        <span class="error-message">Has d'indicar un dni</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="birthDate">Data de naixement*:</label>
                                        <input type="date" name="birthDate" id="birthDate" class="form-control"
                                            tabindex="5" value="{{ old('birthDate') }}" />
                                        @if($errors->has('dni'))
                                        <span class="error-message">Has d'indicar un dni</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="sex">Sexe:</label>
                                        <select id="sex" name="sex" class="form-control" tabindex="6">
                                            <option value="Undefinded" @if (old('sex')=="Undefinded" ||
                                                old('sex')==null) {{'selected'}} @endif> </option>
                                            <option value="Dona" @if (old('sex')=="Dona" ) {{ 'selected' }} @endif>Dona
                                            </option>
                                            <option value="Home" @if (old('sex')=="Home" ) {{ 'selected' }} @endif>Home
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-4">
                                        <label for="email">E-mail:</label>
                                        <input type="email" name="email" id="email" class="form-control" tabindex="7"
                                            value="{{ old('email')}}" />                                        
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="mobile">Teléfon móvil:</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control" tabindex="8"
                                            value="{{ old('mobile')}}" />                                        
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="phone">Teléfon fixe:</label>
                                        <input type="text" name="phone" id="phone" class="form-control" tabindex="9"
                                            value="{{ old('phone')}}" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-4">
                                        <label for="sociProtector">Soci protector:</label>
                                        <select id="sociProtector" name="sociProtector" class="form-control"
                                            tabindex="10">
                                            <option value="0" @if (old('sociProtector')=="0" ||
                                                old('sociProtector')==null) {{ 'selected' }} @endif>NO</option>
                                            <option value="1" @if (old('sociProtector')=="1" ) {{ 'selected' }} @endif>
                                                SI</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <input type="hidden" id="imgPreviewName"
                                    value="{{old("imgPreviewName",Illuminate\Support\Str::random(8).date('Ymdhm'))}}" />
                                <input type="hidden" id="imgName" name="imgName" value="{{old("imgPreviewName")}}" />
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="cabinet center-block">
                                                <figure>
                                                    <img src="" class="gambar img-responsive img-thumbnail"
                                                        id="item-img-output" />
                                                    <figcaption><i class="fa fa-camera"></i></figcaption>
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
                    <div class="col-12">
                        Adreça
                        <div class="row">
                            <div class="col-12">
                                <div class="form-row">
                                    <div class="form-group col-2">
                                        <label for="road">Via:</label>
                                        <select id="road" name="road" class="form-control" tabindex="11">
                                            @foreach($roads as $road)
                                            <option value="{{$road->road}}" @if (($loop->first && old("road")==null ) ||
                                                old("road")==$road->road) selected @endif
                                                >{{$road->road}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-7">
                                        <label for="address">Adreça*:</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            list="addresses" tabindex="12" value="{{old("address")}}" />
                                        @if($errors->has('address'))
                                        <span class="error-message">Has d'indicar una adreça</span>
                                        @endif
                                        <datalist id="addresses">
                                            @foreach($addresses as $address)
                                            <option value="{{$address->address}}">
                                                @endforeach
                                        </datalist>
                                    </div>
                                    <div class="form-group col-1">
                                        <label for="addressNum">Número*:</label>
                                        <input type="number" name="addressNum" id="addressNum" class="form-control"
                                            tabindex="13" value="{{old("addressNum")}}" />
                                        @if($errors->has('addressNum'))
                                        <span class="error-message">Has d'indicar un número de porta</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-1">
                                        <label for="addressFloor">Pis:</label>
                                        <input type="number" name="addressFloor" id="addressFloor" class="form-control"
                                            tabindex="14" value="{{old("addressFloor")}}"/>
                                    </div>
                                    <div class="form-group col-1">
                                        <label for="addressDoor">Porta:</label>
                                        <input type="text" name="addressDoor" id="addressDoor" class="form-control"
                                            tabindex="15" value="{{old("addressDoor")}}" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-4">
                                        <label for="postalCode">Codi postal*:</label>
                                        <input type="text" name="postalCode" id="postalCode" class="form-control"
                                            tabindex="16" value="{{old("postalCode")}}"/>
                                            @if($errors->has('postalCode'))
                                        <span class="error-message">Has d'indicar un número Postal</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="city">Població*:</label>
                                        <input type="text" name="city" id="city" class="form-control" tabindex="17" value="{{old("city")}}" />
                                        @if($errors->has('city'))
                                        <span class="error-message">Has d'indicar una ciutat</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        Dades Bancaries
                        <div class="row">
                            <div class="col-12">
                                <div class="form-row">
                                    <div class="form-group col-4">
                                        <label for="accountHolder">Nom complert del Titular (Si es diferent del
                                            Soci):</label>
                                        <input type="text" name="accountHolder" id="accountHolder" class="form-control"
                                            tabindex="18" value="{{old('accountHolder')}}"/>
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="dniHolder">Dni del Titular (Si es diferent del Soci):</label>
                                        <input type="text" name="dniHolder" id="dniHolder" class="form-control"
                                            tabindex="19" value="{{old('dniHolder')}}"/>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label for="iban">IBAN:</label>
                                        <input type="text" name="iban" id="iban" class="form-control" tabindex="20" value="{{old('iban')}}" />
                                        <input type="hidden" name="correctIban" id="correctIban" value="false" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center ">
                    <button type="submit " class="btn btn-primary " style="padding:8px 100px;margin-top:25px; ">
                        Crear
                    </button>
                </div>
            </form>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Tancar</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">Carregar</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
    // Start upload preview image
    $(".gambar").attr("src", "/storage/socis/default.png");
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
        imgPreviewName = $("#imgPreviewName").val();
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
                data: {"image":img,"imgName":imgPreviewName},
                success: function (resp) {
                    if(resp.status)
                    {
                        $('#item-img-output').attr('src',img);
                        $("#imgName").val(resp.imgName);
                        $('#cropImagePop').modal('hide');
                    }
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function(){
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