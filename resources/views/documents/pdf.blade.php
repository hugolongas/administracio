@extends('layouts.master', ['body_class' => 'documents crear'])
@section('content')
<div class="options-menu">

    <a href="{{ url()->previous() }}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Veure Document</h2>
        <div style="padding:30px ">
            <object data="{{asset('storage/documents/'.$document->file_name)}}" type="application/pdf" width='1000px' height='550px' >
                <p>Alternative text - include a link <a href="{{asset('storage/documents/'.$document->file_name)}}">to the PDF!</a></p>
              </object>
        </div>
        @stop