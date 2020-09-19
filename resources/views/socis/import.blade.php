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
</style>
@stop
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
<div>
    <form action="{{route('socis.importSocis') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                    <a href="{{asset('storage').'/plantilla.xlsx'}}" target="_blank" class="btn btn-outline-dark" >Descarregar plantilla </a> 
                <div class="form-group">                    
                    <label class="col-md-3" for="sample_file">Carregar el fitxer</label>
                    <div class="col-md-9">
                        <input type="file" class="form-control" name="sample_file" id="sample_file" />
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <input type="submit" class="btn btn-outline-primary" />
            </div>
        </div>
    </form>
</div>
@stop

@section('js')
@stop