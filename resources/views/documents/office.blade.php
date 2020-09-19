@extends('layouts.master', ['body_class' => 'documents crear'])
@section('content')
<div class="options-menu">

    <a href="{{ url()->previous() }}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Veure Document</h2>
        <div style="padding:30px ">
            <iframe
                src='https://view.officeapps.live.com/op/embed.aspx?src={{asset('storage/documents/'.$document->file_name)}}'
                width='1000px' height='550px' frameborder='0'>This is an embedded <a target='_blank'
                    href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank'
                    href='http://office.com/webapps'>Office Online</a>.</iframe>
        </div>
        @stop