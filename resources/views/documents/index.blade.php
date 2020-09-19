@extends('layouts.master', ['body_class' => 'documents'])
@section('css')
@stop
@section('js')
@stop
@section('content')
<div class="row">
    @foreach ($documents as $d)
    <div class="col-xs-6 col-md-4 col-lg-3 document-item">
    <a href="{{ route('documents.show', ['document' => $d])}}">
        <div class="row">
            <div class="col-4">
                <img src="{{asset('img')}}/{{$d->type}}.png" class="img-fluid">
            </div>
            <div class="col-6 title">
                {{$d->title}}
            </div>
            <div class="col-12 description">
                {!! $d->summary!!}
            </div>
        </div>
        </a>
    </div>
    @endforeach
</div>
@stop
@push('scripts')
@endpush