@extends('layouts.login')
@section('content')
<div class="container" style="margin-bottom: 90px;">
    <div class="row">
        <div class="col-12 logo-login">
            <img class="img-fluid logo-ateneu" src="{{ asset('img/logo.png') }}" alt="logo" />
        </div>
    </div>
    <div style="margin: 75px auto;font-size: 30px;">
        Benvolguts socis a continuació podeu accedir als projectes per el concurs del bar.
    </div>
    <div class="row">
        <div class="col-6">
            <div class="project-container">                                
                    <h4 style="text-align: center">Projecte 1</h4>
                    <div class="project-icon" style="margin: 0px auto;max-width: 240px;">
                        <a href="{{asset('storage/pdf').'/projecte_1.pdf'}}" target="_blank">
                        <img class="img-fluid" src="{{asset('img/pdf.png')}}" />
                        </a>
                    </div>                
            </div>
        </div>
        <div class="col-6">
            <div class="project-container">                                
                <h4 style="text-align: center">Projecte 2</h4>
                <div class="project-icon" style="margin: 0px auto;max-width: 240px;">
                        <a href="{{asset('storage/pdf').'/projecte_2.pdf'}}" target="_blank">
                        <img class="img-fluid" src="{{asset('img/pdf.png')}}" />
                    </a>
                    </div>
                
            </div>
        </div>
    </div>
</div>
@endsection